<?php

namespace App\Console\Commands;

use App\Acme\Wrapers\Utils;
use Illuminate\Console\Command;
use Symfony\Component\Process\Process;

class GeneratePdf extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:pdf {id} {col?} {type?} {date_en?} {date_in?}';

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
        // $this->log = new Monolog("generate_pdf");
        // $this->log->pushHandler(new StreamHandler(storage_path('logs/pdf/' . Carbon::now()->toDateString() . '.log'), Monolog::INFO));
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle(Utils $dao)
    {
        $id = $this->argument('id');

        //$this->log->info('Generating pdf started for benchmark ' . $id);

        $date_en = is_null($this->argument('date_en')) ? 7 : $this->argument('date_en');
        $date_in = is_null($this->argument('date_in')) ? 7 : $this->argument('date_in');
        $col = is_null($this->argument('col')) ? 1 : $this->argument('col');
        $type = is_null($this->argument('type')) ? 'desc' : $this->argument('type');

        $filename = 'benchmark-' . $id;

        $url = url('/benchmarks/render/' . $id . '/' . $col . '/' . $type . '/' . $date_en . '/' . $date_in);

        $fullPath = storage_path('app/pdf/' . $filename . '.pdf');

        if (file_exists($fullPath)) {
            unlink($fullPath);
        }

        $cmd = 'xvfb-run wkhtmltopdf --image-dpi 300 --image-quality 80 --disable-internal-links -L 0mm -R 0mm -T 0mm -B 0mm -O landscape --javascript-delay 2000 ' . $url . ' ' . $fullPath . ' 2>&1';

        $process = new Process($cmd);
        $process->run();

        if (!$process->isSuccessful()) {
            //dd($process->getOutput());
            //$this->log->info('pdf created Successfully' . $process->getOutput());
        }
        //dd($process->getOutput());
        // cleanCache($id);
        // $dao->getBenchmarkHtml($id);
        // $this->log->info('pdf created Successfully');
    }
}
