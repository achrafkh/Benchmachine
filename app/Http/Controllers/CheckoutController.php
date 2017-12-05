<?php

namespace App\Http\Controllers;

use App\Benchmark;
use Artisan;
use Cache;
use Illuminate\Http\Request;
use Session;
use \Stripe\Stripe;

class CheckoutController extends Controller
{
    protected $stripe;
    // init stripe client
    public function __construct(Stripe $stripe)
    {
        $this->stripe = $stripe;
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
                'amount' => config('price.usd') . '00',
                'currency' => 'usd',
                "description" => "Benchmark",
                "receipt_email" => auth()->user()->getValidEmail(),
                'source' => $request->stripeToken,
            ]);
        } catch (\Exception $e) {
            Session::flash('flash', ['class' => 'danger', 'msg' => $e->getMessage()]);
            return redirect('/benchmarks/' . $request->benchmark_id);
        }
        $benchmark = Benchmark::find($request->benchmark_id);
        $benchmark->since = $request->since;
        $benchmark->until = $request->until;
        $benchmark->status = 1;
        $benchmark->save();

        Artisan::call('fetch:benchmark', [
            'id' => $benchmark->id,
        ]);
        Cache::forget($benchmark->id);

        Session::flash('flash', ['class' => 'success', 'msg' => 'Thank you for your payement']);
        return redirect('/benchmarks/' . $request->benchmark_id);
    }
}
