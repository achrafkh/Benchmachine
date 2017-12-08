<?php

namespace App\Http\Controllers;

use App\Acme\Gateway;
use App\Benchmark;
use App\Order;
use Artisan;
use Cache;
use Illuminate\Http\Request;
use Session;
use \Stripe\Stripe;

class CheckoutController extends Controller
{
    protected $stripe;
    // init stripe client
    public function __construct(Stripe $stripe, Gateway $gateway)
    {
        $this->stripe = $stripe;
        $this->gpg = $gateway;
        $this->stripe->setApiKey(env('STRIPE_SECRET'));
    }

    /**
     * Perform the payment using the token provided from stripe checkout payment form
     * Update benchmark and refetch data
     * Clean cache
     * @param  Array , title and benchmark id
     * @return \Illuminate\Http\Response
     */
    public function checkout(Request $request)
    {
        try {
            $charge = \Stripe\Charge::create([
                'amount' => 500,
                'currency' => 'usd',
                "description" => "Benchmark",
                "receipt_email" => auth()->user()->getValidEmail(),
                'source' => $request->stripeToken,
            ]);
        } catch (\Exception $e) {
            Session::flash('flash', ['class' => 'danger', 'msg' => $e->getMessage()]);
            return redirect('/benchmarks/' . $request->benchmark_id);
        }

        $params['id'] = $request->benchmark_id;
        $params['until'] = $request->until;
        $params['since'] = $request->since;

        $this->processSuccessPayment($params);

        Session::flash('flash', ['class' => 'success', 'msg' => 'Thank you for your payement']);
        return redirect('/benchmarks/' . $request->benchmark_id);
    }

    public function gpgCheckout(Request $request)
    {
        $benchmark = Benchmark::with('order')->find($request->benchmark_id);

        if (is_null($benchmark->order)) {
            $order = Order::create([
                'id' => 'machine-' . str_random(40),
                'total' => 10,
                'status' => 0,
                'benchmark_id' => $benchmark->id,
                'user_id' => auth()->user()->id,
            ]);
        } else {
            $order = $benchmark->order;
        }
        $benchmark->since = $request->since;
        $benchmark->until = $request->until;
        $benchmark->save();

        $params['currency'] = 'TND';
        $params['amount'] = $order->total;
        $params['order_desc'] = 'Benchmark for 6 pages - From : ' . $benchmark->since . ' | To :  ' . $benchmark->until;
        $params['order_id'] = $order->id;

        return $this->gpg->pay($params);
    }

    private function processSuccessPayment($params)
    {
        $benchmark = Benchmark::find($params['id']);
        $benchmark->since = $params['since'];
        $benchmark->until = $params['until'];
        $benchmark->status = 1;
        $benchmark->save();

        Artisan::call('fetch:benchmark', [
            'id' => $benchmark->id,
        ]);

        cleanCache($benchmark->id);

        return true;
    }
}
