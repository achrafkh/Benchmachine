<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use Illuminate\Console\Command;
use Monolog\Handler\StreamHandler;
use Monolog\Logger as Monolog;
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
        $this->log = new Monolog("generate_pdf");
        $this->log->pushHandler(new StreamHandler(storage_path('logs/pdf/' . Carbon::now()->toDateString() . '.log'), Monolog::INFO));
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $id = $this->argument('id');
        $this->log->info('Generating pdf started for benchmark ' . $id);

        $filename = 'benchmark-' . $id;
        $secret = env('SECRET');
        $url = url('/benchmarks/render/' . $id . '/' . $secret);
        $fullPath = storage_path('app/pdf/' . $filename . '.pdf');

        $cmd = 'xvfb-run wkhtmltopdf -L 0mm -R 0mm -T 0mm -B 0mm -O landscape --javascript-delay 2000 ' . $url . ' ' . $fullPath . ' 2>&1';

        $process = new Process($cmd);
        $process->run();

        if (!$process->isSuccessful()) {
            $this->log->info('pdf created Successfully' . $process->getOutput());
        }
        $this->log->info('pdf created Successfully');
    }
}
