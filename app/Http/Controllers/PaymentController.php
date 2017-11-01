<?php

namespace App\Http\Controllers;

use App\Acme\Gateway;
use App\Order;
use Artisan;
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

    public function Initpayment($id)
    {
        $user = auth()->user();
        $order = Order::with('benchmark')->find($id);
        if (!$user->hasDetails()) {
            abort(401, 'User have no details');
        }

        //$params['currency'] = strtoupper($cur);
        $params['currency'] = 'EUR';
        $params['amount'] = inEuro($order->total);
        $params['order_desc'] = 'Benchmark for 6 pages - From : ' . $order->benchmark->from . ' | To :  ' . $order->benchmark->from;
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
        $data = Cache::get($token);
        $order = Order::with('benchmark')->find($data)->first();
        $order->benchmark->updateStatus(1);
        $order->status = 1;
        $order->save();

        Artisan::call('fetch:benchmark', [
            'id' => $order->benchmark->id,
        ]);

        Cache::forget($token);

        return redirect('/home');
        if (is_null($data)) {
            abort(404);
        }
    }
}
