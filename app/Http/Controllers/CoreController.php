<?php

namespace App\Http\Controllers;

use App\Benchmark;

class CoreController extends Controller
{

    /**
     * Takes  a benchmark temporary token and marks benchmark as ready
     * Notify benchmark owner
     * (Kpeiz core will call this endpoint)
     * @param String $token Temporary token
     * @return void
     */
    public function benchmarkReady($token, $id)
    {
        $benchmark = Benchmark::with('user', 'accounts')->where('temp_id', $token)->first();

        if (!$benchmark->isReady()) {
            // maybe % or smth for a progress bar or time estimation
            return false;
        }

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
