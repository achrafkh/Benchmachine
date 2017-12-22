<?php

namespace App\Http\Controllers;

use App\Account;
use App\Acme\Wrapers\DAO;
use App\Acme\Wrapers\Utils;
use App\Benchmark;
use App\Http\Requests\AddpagesRequest;
use App\Order;
use Artisan;
use Cache;
use Carbon\Carbon;
use File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use PDF;
use Symfony\Component\Process\Process;

class BenchmarksController extends Controller
{
    protected $api;
    protected $repo;
    /**
     * Create a new controller instance.
     * @param DAO $api An instance of DAO class
     * @param Utils $repo An instance of Utils class
     * @return void
     */
    public function __construct(DAO $api, Utils $repo)
    {
        $this->api = $api;
        $this->repo = $repo;
    }

    public function getBenchmarks()
    {
        $benchmarks = auth()->user()->benchmarks()->with('accounts', 'order')->get();

        return response()->json($benchmarks);
    }

    /**
     * Render a benchmark to the browser
     * also it adds the benchmark to cache for certain amount of time
     * @param  $id Integer Benchmark id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $benchmark = Benchmark::with('accounts')->find($id);

        $benchmark_ids = $benchmark->accounts->pluck('id')->toarray();

        $response = cpost(env('CORE2') . '/platform/check-pages', ['pages_ids' => $benchmark_ids]);

        if ((1 == $response->status) && (2 != $benchmark->status)) {
            $benchmark->markAsReady(auth()->user()->getValidEmail());
        }
        if (0 == $response->status) {
            return view('facebook.loading', compact('benchmark', 'benchmark_ids'));
        }
        if (2 != $benchmark->status) {
            return view('facebook.loading', compact('benchmark', 'benchmark_ids'));
        }
        $benchmark = Cache::remember($id, env('CACHE_TIME'), function () use ($id) {
            return $this->repo->getBenchmark($id);
        });

        return view('facebook.benchmark', compact('benchmark'));
    }

    /**
     * Render a benchmark to the browser
     * Generates a Static html file for current benchmark
     * @param  $id Integer Benchmark id
     * @return \Illuminate\Http\Response
     */
    public function showStatic($id)
    {

        $benchmark = Benchmark::with('accounts')->find($id);

        $class = 'pending_page';

        $this->authorize('view', $benchmark);

        $file = public_path() . '/static/app/benchmark-' . $id . '.html';

        if (file_exists($file)) {
            $html = $this->repo->getBenchmarkHtml($id);
            $html = str_insert($html, '<body class="">', getHtmlHeader(auth()->user()->name, auth()->user()->image, $id));
            return view('facebook.benchmark_html', compact('html'));
        }

        $benchmark_ids = $benchmark->accounts->pluck('id')->toarray();

        $response = cpost(env('CORE2') . '/platform/check-pages', ['pages_ids' => $benchmark_ids]);

        if (isset($response)) {
            if ((1 == $response->status) && (2 != $benchmark->status)) {
                $benchmark->markAsReady(auth()->user()->getValidEmail());
            }

            if (0 == $response->status) {
                return view('facebook.loading', compact('benchmark', 'benchmark_ids', 'class'));
            }
            if (2 != $benchmark->status) {
                return view('facebook.loading', compact('benchmark', 'benchmark_ids', 'class'));
            }
        }
        $html = $this->repo->getBenchmarkHtml($id);

        $html = str_insert($html, '<body class="">', getHtmlHeader(auth()->user()->name, auth()->user()->image, $id));

        return view('facebook.benchmark_html', compact('html'));
    }

    /**
     * Download A benchmark as PDF
     * This uses Dompdf to generate the file
     * @param  $id Integer Benchmark id
     * @return \Illuminate\Http\Response
     */
    public function download($id)
    {
        $benchmark = $this->repo->getBenchmark($id);
        $pdf = PDF::loadView('facebook.pdf', compact('benchmark'));

        return $pdf->download('report.pdf');
    }

    /**
     * Generate a benchmark and render it to the screen without header
     * wkhtmltopdf  will generate pdf from this view
     * @param  $id Integer Benchmark id
     * @param  $secret String Secret code to make sure that the call is internal
     * @return \Illuminate\Http\Response
     */
    public function render($id, $col, $type, $date_en, $date_in)
    {
        cleanPrintCache($id);

        $html = $this->repo->getBenchmarkHtml($id, true, compact('col', 'type', 'date_en', 'date_in'));

        return view('facebook.benchmark_html', compact('html'));
    }

    /**
     * Generate a PDF file and send it to the user using wkhtmltopdf
     * if the file already exists, use the available one
     * @param  $id Integer Benchmark id
     * @return \Illuminate\Http\Response
     */
    public function wkdownload($id, Request $request)
    {

        if ('default' == $id) {
            $url = url('/default/yes');

            $fullPath = storage_path('app/pdf/default.pdf');

            $cmd = 'xvfb-run wkhtmltopdf -L 0mm -R 0mm -T 0mm -B 0mm -O landscape --javascript-delay 2000 ' . $url . ' ' . $fullPath . ' 2>&1';

            $process = new Process($cmd);
            $process->run();

            return response()->download(storage_path('app/pdf/default.pdf'));
        }

        $path = 'pdf/benchmark-' . $id . '.pdf';
        $data = $request->except('_token');

        Artisan::call('make:pdf', [
            'id' => $id,
            'col' => $data['col'],
            'type' => $data['type'],
            'date_en' => $data['chartdate_en'],
            'date_in' => $data['chartdate_in'],
        ]);

        return response()->download(storage_path('app/' . $path));
    }

    /**
     * Create a benchmark using the provided data in the request
     * This is for the Non paid benchmarks (free)
     * @param  \Illuminate\Http\Request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $accounts = $request->account_ids;

        $title = 'Benchmark';

        if ($request->has('title')) {
            $title = $request->title;
        }

        $since = Carbon::parse($request->since)->toDateString();
        $until = Carbon::parse($request->until)->toDateString();

        $benchmark = $this->api->prepareBenchmark($accounts, $since, $until, $title, auth()->user()->id);

        $order = Order::create([
            'user_id' => auth()->user()->id,
            'benchmark_id' => $benchmark->id,
            'total' => 25,
            'id' => 'machine-' . str_random(30),
            'status' => 0,
        ]);

        return redirect('/home');
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
        if (isset($response['pages'])) {
            return response()->json(['pages' => $response['pages']]);
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
     * Update benchmark title
     * Delete cache after update
     * @param  Array , title and benchmark id
     * @return \Illuminate\Http\Response
     */
    public function updateTitle(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'min:4|max:60',
            'id' => 'exists:benchmarks,id',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 200,
                'msg' => 'error',
                'errors' => $validator->errors()->first(),
            ]);
        }

        Benchmark::where('id', $request->id)
            ->update(['title' => $request->title]);

        cleanCache($request->id, false);

        return response()->json([
            'status' => 200,
            'msg' => 'success',
        ]);
    }
}
