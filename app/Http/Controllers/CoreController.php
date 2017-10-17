<?php

namespace App\Http\Controllers;

use App\Benchmark;
use App\Mail\NotifyUser;
use Mail;

class CoreController extends Controller
{

    /**
     * Takes  a benchmark temporary token and marks benchmark as ready
     * Notify benchmark owner
     * (Kpeiz core will call this endpoint)
     * @param String $token Temporary token
     * @return void
     */
    public function benchmarkReady($token)
    {
        $benchmark = Benchmark::with('user')->where('temp_id', $token)->first();
        $benchmark->temp_id = null;
        $benchmark->status = 1;
        $benchmark->save();

        //dispatch(new GenerateBenchmark($benchmark->id));

        Mail::to($benchmark->user->email)
            ->send(new NotifyUser($benchmark));

        // will be logged in core
        return response()->json('Notified Successfully');
    }
}
