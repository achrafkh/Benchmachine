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
use Illuminate\Support\Facades\Validator;
use Session;

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
        $this->middleware('auth', ["except" => ["index", "validatePages", "createDemo", "defaultBenchmark"]]);
    }

    /**
     * Render Front page
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('welcome', ['class' => 'home_page']);
    }

    public function defaultBenchmark($print = 'no')
    {
        if ('yes' == $print) {
            $html = file_get_contents(public_path() . '/example_print.html');
        } else {
            $html = file_get_contents(public_path() . '/example.html');
            $user_name = (auth()->check()) ? auth()->user()->name : 'Guest';
            $user_image = (auth()->check()) ? auth()->user()->image : 'https://api.drupal.org/sites/default/files/default-avatar.png';

            $html = str_insert($html, '<body class="">', getHtmlHeader($user_name, $user_image, 'default'));
        }

        return view('facebook.benchmark_html', compact('html'));
    }

    // save user details
    public function saveDetails(Request $request)
    {
        $response = auth()->user()->saveData($request->all());

        if (!$response) {
            return response()->json(['status' => 0]);
        }
        return response()->json(['status' => 1]);
    }

    //show 7 days benchmark (Geerates a static html file)
    public function showDemoStatic($id)
    {
        $benchmark = Benchmark::with('accounts')->find($id);
        $benchmark_ids = $benchmark->accounts->pluck('id')->toarray();

        $response = cpost(env('CORE') . '/platform/check-pages', ['pages_ids' => $benchmark_ids]);

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

        $response = $this->api->addPages($accounts);

        // If isset pages that means there are errors in this links
        if (isset($response['pages'])) {
            $resp = [];
            foreach ($response['pages'] as $page) {
                $key = array_search($page, $accounts);
                $resp[$key] = $page;
            }
            return response()->json(['pages' => $resp]);
        }

        $response['account_ids']->each(function ($account) {

            Account::updateOrCreate(['id' => $account->id],
                [
                    'real_id' => $account->real_id,
                    'label' => $account->label,
                    'title' => $account->title,
                    'image' => $account->image,
                ]);
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

        $title = 'Benchmark';

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
        $user_id = null;
        if (auth()->check()) {
            $user_id = auth()->user()->id;
        }
        $benchmark = $this->api->prepareBenchmark($accounts, $since, $until, $title, $user_id);

        Artisan::call('fetch:benchmark', [
            'id' => $benchmark->id,
        ]);
        Session::put('benchmark', $benchmark->id);

        return response()->json($benchmark->id);
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

    public function editEmail(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
        ]);

        if ($validator->fails()) {
            Session::flash('flash', ['class' => 'danger', 'msg' => $validator->errors()->first()]);
        } else {
            auth()->user()->setEmail($request->email);
        }

        Session::put('email-' . $request->id, true);

        return redirect()->back();
    }

    public function showModal($id)
    {
        if (Session::has('email-' . $id)) {
            return response()->json(0);
        }
        return response()->json(1);
    }
}
