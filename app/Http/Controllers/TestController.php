<?php

namespace App\Http\Controllers;

use App\Acme\Gateway;
use App\Order;

class TestController extends Controller
{
    protected $gateway;

    public function __construct(Gateway $gateway)
    {
        $this->gateway = $gateway;
    }

    public function test($id)
    {
        $order = Order::find($id);
        return $this->gateway->process($order->id);
    }
}
