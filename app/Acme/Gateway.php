<?php

namespace App\Acme;

use GuzzleHttp\Client;

class Gateway
{
    protected $client;

    /**
     * Create a new Class instance and instantiate guzzle client.
     * @return void
     */
    public function __construct()
    {
        $this->client = new Client(['base_uri' => trim(env('PAY_CLIENT'), '/'), 'verify' => false]);
    }

    /**
     * Execute a http call
     * @param  $call Endpoint
     * @param  $params Array Params
     * @param  $method String Http request method
     * @return \Illuminate\Http\Response
     */
    public function post($call, $params = [], $method = 'POST')
    {
        try {
            return json_decode($this->client
                    ->request($method, $call, ['form_params' => $params])
                    ->getBody()
                    ->getContents());
        } catch (\Exception $e) {
            dd($e->getMessage());
            return json_decode($e->getResponse()->getBody()->getContents());
        }
    }

    /**
     * Setup & Redirect to payment gateway
     * @param  $params Array Params required for payment
     * @return \Illuminate\Http\Response
     */
    public function pay($params)
    {
        $post_url = '/gateway/pay';
        $redirect_url = trim(env('PAY_CLIENT'), '/') . '/gateway/process/';

        $response = $this->post($post_url, $params);

        if (200 != $response->status) {
            abort(500);
        }
        return redirect()->away($redirect_url . $response->token);
    }

    public function process($id)
    {
        $params['PAYID'] = $id;

        $output = $this->post(trim(env('PAY_CLIENT'), '/') . '/payement/notification', $params);

        if ((!$output) || ($output != $params['PAYID'])) {
            dd($output);
        }

        return redirect()->away(trim(env('PAY_CLIENT'), '/') . '/payement/done/' . $output);
    }
}
