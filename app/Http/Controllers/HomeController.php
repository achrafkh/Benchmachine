<?php

namespace App\Http\Controllers;

use App\Account;
use App\Acme\Wrapers\DAO;
use App\Acme\Wrapers\Utils;
use App\Benchmark;
use App\Http\Requests\AddpagesRequest;
use Artisan;
use Carbon\Carbon;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    protected $repo;
    protected $api;
    /**
     * Create a new controller instance.
     * @param Utils $repo An instance of Utils class
     * @return void
     */
    public function __construct(Utils $repo, DAO $api)
    {
        $this->api = $api;
        $this->repo = $repo;

        $this->middleware('guest', ["except" => ["home"]]);
    }

    /**
     * Render Front page
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('welcome');
    }

    public function saveDetails(Request $request)
    {

        $response = auth()->user()->saveData($request->all());

        if (!$response) {
            return response()->json(['status' => 0]);
        }
        return response()->json(['status' => 1]);
    }

    public function showDemoStatic($id)
    {
        $benchmark = Benchmark::with('accounts')->find($id);
        $benchmark_ids = $benchmark->accounts->pluck('id')->toarray();

        $response = cpost(env('CORE') . '/platform/check-pages', ['pages_ids' => $benchmark_ids]);
        // dd($response, $benchmark->toarray());
        if ((1 == $response->status) && (2 != $benchmark->status)) {
            $benchmark->markAsReady();
        }
        if (2 != $benchmark->status) {
            return view('facebook.loading', compact('benchmark', 'benchmark_ids'));
        }

        $html = $this->repo->getBenchmarkHtml($id);

        $html = str_insert($html, '<body class="">', getHtmlHeader('Guest', '', $id));

        return view('facebook.benchmark_html', compact('html'));
    }

    /**
     * Validation for Index page form
     * There must be at least 2 valid pages
     * @param  \Illuminate\Http\Request
     * @return \Illuminate\Http\Response
     */
    public function validatePages(AddpagesRequest $request)
    {
        $accounts = $request->accounts;
        if (count($accounts) < 2) {
            return response()->json(['min' => true]);
        }
        if (!$request->has('email')) {
            return response()->json(['email' => true]);
        }

        $response = $this->api->addPages($accounts);

        if (isset($response['pages'])) {
            $resp = [];
            foreach ($response['pages'] as $page) {
                $key = array_search($page, $accounts);
                $resp[$key] = $page;
            }
            return response()->json(['pages' => $resp]);
        }
        $response['account_ids']->each(function ($account) {
            Account::updateOrCreate(['id' => $account->id], ['real_id' => $account->real_id]);
        });
        return response()->json(['success' => true, 'ids' => $response['account_ids']->pluck('id')->toarray()]);
    }

    /**
     * Create a benchmark using the provided data in the request
     * This is for the Non paid benchmarks (free)
     * @param  \Illuminate\Http\Request
     * @return \Illuminate\Http\Response
     */
    public function createDemo(Request $request)
    {
        $accounts = $request->accounts;

        $title = 'My Benchmark';

        if ($request->has('title')) {
            $title = $request->title;
        }
        $email = null;
        if ($request->has('email')) {
            $email = $request->email;
        }
        $since = Carbon::now()->subDays(8)->toDateString();
        $until = Carbon::now()->subDays(1)->toDateString();

        $response = $this->api->addPages($accounts);

        $accounts = $response['account_ids']->pluck('id');
        $status = $response['status'];

        $benchmark = $this->api->prepareBenchmark($accounts, $since, $until, $title);
        if (1 == $status) {
            $benchmark->markAsReady($email);
        } else {
            Artisan::call('fetch:benchmark', [
                'id' => $benchmark->id,
            ]);
        }
        return redirect('/benchmarks/init/' . $benchmark->id);
    }

    /**
     * Show the application dashboard after authentication.
     *
     * @return \Illuminate\Http\Response
     */
    public function home()
    {
        $benchmarks = auth()->user()->benchmarks()->with('accounts', 'order')->get();

        return view('home', compact('benchmarks'));
    }
}
