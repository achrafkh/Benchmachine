<?php

namespace App\Http\Controllers;

use App\Acme\Wrapers\DAO;
use App\Acme\Wrapers\Utils;
use App\Benchmark;
use App\Http\Requests\AddpagesRequest;
use Artisan;
use Cache;
use Carbon\Carbon;
use File;
use Illuminate\Http\Request;
use PDF;
use Storage;

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

    /**
     * Render a benchmark to the browser
     * also it adds the benchmark to cache for certain amount of time
     * @param  $id Integer Benchmark id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $benchmark = Cache::remember($id, env('CACHE_TIME'), function () use ($id) {
            return $this->repo->getBenchmark($id);
        });
        return view('facebook.benchmark', compact('benchmark'));
    }

    public function showStatic($id)
    {
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
    public function render($id, $secret)
    {
        if (env('SECRET') != strtoupper($secret)) {
            abort(401, 'UNAUTHORIZED');
        }

        $html = $this->repo->getBenchmarkHtml($id);
        return view('facebook.benchmark_html', compact('html'));
    }

    /**
     * Generate a PDF file and send it to the user using wkhtmltopdf
     * if the file already exists, use the available one
     * @param  $id Integer Benchmark id
     * @return \Illuminate\Http\Response
     */
    public function wkdownload($id)
    {
        $path = 'pdf/benchmark-' . $id . '.pdf';

        if (!Storage::exists($path)) {
            // Generate the pdf and save it to storage/app/pdf/
            //File name will be benchmark-{id}.pdf
            Artisan::call('make:pdf', [
                'id' => $id,
            ]);
        }
        return response()->file(storage_path('app/' . $path));
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

        $since = Carbon::now()->subDays(8)->toDateString();
        $until = Carbon::now()->subDays(1)->toDateString();

        $benchmark = $this->api->createBenchmark($accounts, $since, $until, $title);

        return redirect('/home');
    }

    /**
     * Create a benchmark using the provided data in the request
     * This is for the Non paid benchmarks (free)
     * @param  \Illuminate\Http\Request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $accounts = $request->accounts;

        $title = 'My Benchmark';

        if ($request->has('title')) {
            $title = $request->title;
        }

        $since = Carbon::parse($request->since)->toDateString();
        $until = Carbon::parse($request->until)->toDateString();

        $benchmark = $this->api->createBenchmark($accounts, $since, $until, $title);

        return redirect('/');
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

        return response()->json(['success' => true]);
    }
}
