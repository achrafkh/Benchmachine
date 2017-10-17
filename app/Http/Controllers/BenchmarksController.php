<?php

namespace App\Http\Controllers;

use App\Acme\Wrapers\DAO;
use App\Acme\Wrapers\Utils;
use App\Benchmark;
use App\Http\Requests\AddpagesRequest;
use App\Jobs\GenerateBenchmark;
use Artisan;
use Cache;
use Carbon\Carbon;
use Illuminate\Http\Request;
use PDF;
use Storage;

class BenchmarksController extends Controller
{
    protected $api;

    public function __construct(DAO $api, Utils $repo)
    {
        $this->api = $api;
        $this->repo = $repo;
    }

    public function show($id)
    {
        $benchmark = Cache::remember($id, env('CACHE_TIME'), function () use ($id) {
            return $this->repo->getBenchmark($id);
        });
        return view('facebook.benchmark', compact('benchmark'));
    }

    public function download($id)
    {
        $benchmark = $this->repo->getBenchmark($id);

        $pdf = PDF::loadView('facebook.pdf', compact('benchmark'));
        return $pdf->download('invoice.pdf');
    }

    public function render($id)
    {
        $benchmark = $this->repo->getBenchmark($id);

        return view('facebook.pdf', compact('benchmark'));
    }

    public function wkdownload($id)
    {
        $path = 'pdf/benchmark-' . $id . '.pdf';

        if (!Storage::exists($path)) {
            Artisan::call('make:pdf', [
                'id' => $id,
            ]);
        }
        return response()->file(storage_path('app/' . $path));
    }

    public function create(Request $request)
    {
        $accounts = $request->accounts;

        $title = 'My Benchmark';

        if ($request->has('title')) {
            $title = $request->title;
        }

        $since = Carbon::now()->subDays(8)->toDateString();
        $until = Carbon::now()->subDays(1)->toDateString();

        // Add pages to kpeiz core to collect data
        $pages_ids = $this->api->addPages($accounts);

        $benchmark = Benchmark::create([
            'user_id' => auth()->user()->id,
            'title' => $title,
            'since' => $since,
            'until' => $until,
            'status' => 0,
        ]);

        $benchmark->save();
        $benchmark->accounts()->saveMany($pages_ids);

        dispatch(new GenerateBenchmark($benchmark->id));

        return redirect('/');
    }

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
