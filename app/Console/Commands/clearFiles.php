<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Symfony\Component\Process\Process;

class clearFiles extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'clean:files {type?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Clean generated files';

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
        $type = $this->argument('type');
        $html = public_path() . '/static/app/';
        $pdf = storage_path('app/pdf/');

        if (is_null($type)) {
            $process = new Process('rm -rf ' . $html . '*.html');
            $process->run();
            $process2 = new Process('rm -rf ' . $pdf . '*.pdf');
            $process2->run();
        } elseif ('pdf' == $type) {
            $process = new Process('rm -rf ' . $pdf . '*.pdf');
            $process->run();
        } elseif ('html' == $type) {
            $process = new Process('rm -rf ' . $html . '*.html');
            $process->run();
        }
    }
}
