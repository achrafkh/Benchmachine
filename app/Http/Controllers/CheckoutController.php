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
    public function __construct(Stripe $stripe)
    {
        $this->stripe = $stripe;
        $this->stripe->setApiKey(env('STRIPE_SECRET'));
    }

    public function checkout(Request $request)
    {
        try {
            $charge = \Stripe\Charge::create([
                'amount' => 2000,
                'currency' => 'eur',
                "description" => "Benchmark for 96 days",
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
