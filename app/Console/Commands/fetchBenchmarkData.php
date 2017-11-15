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

        // Collect data from double periode to be able to compare two periode
        // for exemple to make a benchmark for last 7 days, we need data from 14 days
        // so we can calculate variation between last periode and the current one

        $since = Carbon::parse($benchmark->since);
        $until = Carbon::parse($benchmark->until);

        // get difference in days
        $days = $until->diffInDays($since);

        // Subtract those days from since
        $since->subDays($days);

        $api->post('init-machine', [
            'account_ids' => $benchmark->accounts->pluck('id')->toarray(),
            'since' => $since->toDateString(),
            'until' => $benchmark->until,
        ]);
        // $api->post('add-custom-tag', [
        //     'account_ids' => $benchmark->accounts->pluck('id')->toarray(),
        //     'tag' => config('utils.tag'),
        // ]);
    }
}
