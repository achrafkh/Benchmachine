<?php

namespace App\Console\Commands;

use App\Acme\Wrapers\ApiAdapter;
use App\Benchmark;
use Illuminate\Console\Command;

class fetchBenchmarkData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'fetch:benchmark {id}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fetch data for benchmark (Run core on benchmark pages)';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle(ApiAdapter $api)
    {
        $benchmark = Benchmark::with('accounts')->find($this->argument('id'));

        $api->post('init-machine', [
            'account_ids' => $benchmark->accounts->pluck('id')->toarray(),
            'since' => $benchmark->since,
            'until' => $benchmark->until,
        ]);
        // $api->post('add-custom-tag', [
        //     'account_ids' => $benchmark->accounts->pluck('id')->toarray(),
        //     'tag' => config('utils.tag'),
        // ]);
    }
}
