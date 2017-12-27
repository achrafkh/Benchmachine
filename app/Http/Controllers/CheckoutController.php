<?php

namespace App\Http\Controllers;

use App\Acme\Gateway;
use App\Acme\Wrapers\DAO;
use App\Benchmark;
use App\Http\Requests\BenchmarkRequest;
use App\Order;
use Artisan;
use Cache;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Session;
use \Stripe\Stripe;

class CheckoutController extends Controller
{
    protected $stripe;
    // init stripe client
    public function __construct(Stripe $stripe, Gateway $gateway, DAO $api)
    {
        $this->api = $api;
        $this->stripe = $stripe;
        $this->gpg = $gateway;
        $this->stripe->setApiKey(env('STRIPE_SECRET'));
    }

    public function homeCheckout(BenchmarkRequest $request)
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
            return redirect('/home');
        }

        $accounts = $request->accounts;

        $title = $request->title;

        $email = $request->email;

        $since = Carbon::parse($request->since);
        $until = Carbon::parse($request->until);

        $response = $this->api->addPages($accounts);

        $accounts = $response['account_ids']->pluck('id');
        $status = $response['status'];

        $user_id = auth()->user()->id;

        $benchmark = $this->api->prepareBenchmark($accounts, $since, $until, $title, $user_id);

        Artisan::call('fetch:benchmark', [
            'id' => $benchmark->id,
        ]);

        return redirect('/benchmarks/' . $benchmark->id);
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
        Session::flash('payed', true);

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

        cleanCache($benchmark->id, true);

        return true;
    }
}
