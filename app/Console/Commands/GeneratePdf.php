<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Symfony\Component\Process\Process;

class GeneratePdf extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:pdf {id}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate a pdf for a certain benchmark';

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
        $id = $this->argument('id');

        $filename = 'benchmark-' . $id;
        $url = url('/benchmarks/render/' . $id);
        $fullPath = storage_path('app/pdf/' . $filename . '.pdf');

        $cmd = 'xvfb-run wkhtmltopdf -L 0mm -R 0mm -T 0mm -B 0mm -O landscape --javascript-delay 2000 ' . $url . ' ' . $fullPath . ' 2>&1';

        $process = new Process($cmd);
        $process->run();

        if (!$process->isSuccessful()) {
            throw new ProcessFailedException($process);
            // log $process->getOutput();
        }
    }
}
