<?php

namespace App\Console\Commands;

use App\Acme\Wrapers\Utils;
use App\Benchmark;
use Artisan;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Monolog\Handler\StreamHandler;
use Monolog\Logger as Monolog;

class UpdateBenchmarkStatus extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'update:benchmark {id?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update benchmark status if data is ready in core';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();

        $this->log = new Monolog("Benchmark_updates");
        $this->log->pushHandler(new StreamHandler(storage_path('logs/status/' . Carbon::now()->toDateString() . '.log'), Monolog::INFO));
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle(Utils $core)
    {
        $this->log->info('Started Updating process');
        $id = $this->argument('id');

        // if there is an id specified, only process that benchmark
        if ($id) {
            $benchmarks = Benchmark::with('accounts', 'user')->where('id', $id)->get();
            $this->log->info('Checking benchmark ID: ' . $id);
        } else {
            // else check all non ready benchmarks
            $benchmarks = Benchmark::where('status', 1)->with('accounts', 'user')->get();
            $this->log->info('Checking all Benchmarks');
        }

        // loop through all benchmarks
        $benchmarks->each(function ($benchmark) use ($core) {
            // Check if benchmark is ready
            $ready = $core->benchmarkIsReady($benchmark);
            if ($ready) {
                // update Benchmark status if benchmark ready
                $email = false;

                if (isset($benchmark->user)) {
                    $email = $benchmark->user->getValidEmail();
                }
                $benchmark->markAsReady($email);

                Artisan::call('make:pdf', [
                    'id' => $benchmark->id,
                ]);

                $this->log->info('Benchmark ID : ' . $benchmark->id . ' Is ready');
            }
        });
        $this->log->info('Updating Done');
    }
}
