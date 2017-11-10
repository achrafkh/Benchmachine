<?php

namespace App\Mail;

use App\Benchmark;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class NotifyUser extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $benchmark;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Benchmark $benchmark)
    {
        $this->benchmark = $benchmark;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $this->subject('Your Benchmark is ready');
        return $this->view('emails.benchmark_ready');
    }
}
