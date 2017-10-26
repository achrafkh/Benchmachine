<?php

namespace App\Http\Controllers;

use App\Acme\Gateway;
use Cache;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    protected $gateway;
    /**
     * Create a new controller instance.
     * @param Gateway $gateway An instance of Utils class
     * @return void
     */
    public function __construct(Gateway $gateway)
    {
        $this->gateway = $gateway;
    }

    public function testPayment($amount, $cur = 'TND')
    {

        $user = auth()->user();
        if (!$user->hasDetails()) {
            abort(401, 'User have no details');
        }

        $params['currency'] = strtoupper($cur);
        $params['amount'] = $amount;
        $params['order_desc'] = 'Benchmark for 6 pages - From : 2017-05-05 | To :  2017-10-10 ';
        $params['order_id'] = 'machine-' . str_random(40);

        $user = auth()->user()->getPayementDetails();

        return $this->gateway->pay(array_merge($user, $params));
    }

    public function callback(Request $request)
    {
        $response['token'] = str_random(40);
        $response['status'] = 200;

        // Save in DB
        Cache::put($response['token'], $request->all(), 20);

        return response()->json($response);
    }

    public function done($token)
    {
        //Check if token exists in DB
        //Put it in Session and redirect
        dd(Cache::get($token));
    }
}
