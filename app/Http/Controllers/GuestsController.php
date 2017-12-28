<?php

namespace App\Http\Controllers;

use App\Acme\Wrapers\DAO;
use App\Http\Requests\BenchmarkRequest;
use App\Invitation;
use Artisan;
use Carbon\Carbon;
use Session;

class GuestsController extends Controller
{
    public function __construct(DAO $api)
    {
        $this->api = $api;
    }

    public function proccessInvitation($id)
    {
        $invitation = Invitation::find($id);
        $redirect = '/';
        if (auth()->check()) {
            $redirect = '/home';
        }
        if (is_null($invitation)) {
            Session::flash('msg', ['class' => 'danger', 'msg' => "This invitation doesn't exists"]);
            return redirect($redirect);
        }
        if (!is_null($invitation->invited_id)) {
            Session::flash('msg', ['class' => 'danger', 'msg' => "This invitation has been already used"]);
            return redirect($redirect);
        }
        $class = "home_page";
        return view('landing', compact('invitation', 'class'));
    }

    public function newBenchmark(BenchmarkRequest $request)
    {
        $accounts = $request->accounts;

        $invite = Invitation::find($request->invitation);

        if (is_null($invite)) {
            return response()->json(['status' => 0, 'msg' => 'Invitation already used']);
        }

        $title = 'Benchmark';

        if ($request->has('title')) {
            $title = $request->title;
        }
        $email = null;
        if ($request->has('email')) {
            $email = $request->email;
        }
        $since = Carbon::now()->subDays(8)->toDateString();
        $until = Carbon::now()->subDays(1)->toDateString();

        $response = $this->api->addPages($accounts);

        $accounts = $response['account_ids']->pluck('id');
        $status = $response['status'];

        $user_id = null;

        if (auth()->check()) {
            $user_id = auth()->user()->id;
        }
        $benchmark = $this->api->prepareBenchmark($accounts, $since, $until, $title, $user_id);

        Artisan::call('fetch:benchmark', [
            'id' => $benchmark->id,
        ]);
        cleanCache($benchmark->id, true);
        Session::put('benchmark', $benchmark->id);
        Session::put('used_invitation', $invite->id);
        return response()->json(['status' => 1, 'id' => $benchmark->id]);
    }
}
