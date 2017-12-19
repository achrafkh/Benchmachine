<?php

namespace App\Console\Commands;

use DB;
use Illuminate\Console\Command;

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
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $pages_ids = DB::table('new_pages')->pluck('page_id')->toarray();
        if (!count($pages_isd)) {
            return;
        }
        $response = cpost(env('CORE') . '/rest/delete-accounts', ['social-accounts' => $pages_ids]);

        $success = DB::table('new_pages')->whereIn('page_id', $pages_ids)->delete();
    }
}
