<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use DB;
use Illuminate\Console\Command;
use Monolog\Handler\StreamHandler;
use Monolog\Logger as Monolog;

class cleanPages extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'clean:pages';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Remove All newly added pages from core';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();

        $this->log = new Monolog("Benchmark_updates");
        $this->log->pushHandler(new StreamHandler(storage_path('logs/cleanup/' . Carbon::now()->toDateString() . '.log'), Monolog::INFO));
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->log->info('Started Pages Cleanup');

        $pages_ids = DB::table('new_pages')->pluck('page_id')->toarray();

        if (count($pages_ids)) {
            $response = cpost(env('CORE') . '/rest/delete-accounts', ['social-accounts' => $pages_ids]);
        }
        $this->log->info(count($pages_ids) . ' Pages deleted');

        $success = DB::table('new_pages')->whereIn('page_id', $pages_ids)->delete();

        $this->log->info('-----------------------------------------------------------------------------------');
    }
}
