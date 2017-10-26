<?php

namespace App\Http\Controllers;

use App\Acme\Gateway;

class TestController extends Controller
{
    protected $gateway;

    public function __construct(Gateway $gateway)
    {
        $this->gateway = $gateway;
    }

    public function test()
    {
        return $this->gateway->test();
    }
}
