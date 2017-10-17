<?php

namespace App\Acme;

use GuzzleHttp\Client;

class Api
{
    protected $client;

    /**
     * Create a new Class instance and instantiate guzzle client.
     * @return void
     */
    public function __construct()
    {
        $this->client = new Client(['base_uri' => trim(env('CORE'), '/') . '/rest/']);
    }

    /**
     * Render a benchmark to the browser
     * also it adds the benchmark to cache for certain amount of time
     * @param  $call Integer Benchmark id
     * @param  $params Integer Benchmark id
     * @param  $headers Array Headers
     * @param  $method String Http request methot
     * @return \Illuminate\Http\Response
     */
    public function _get($call, $params = [], $headers = [], $method = 'GET')
    {
        //Headers to be fixed
        try {
            return json_decode($this
                    ->client
                    ->request($method, $call, ['query' => array_merge($headers, $params)])->getBody()->getContents());

        } catch (\Exception $e) {
            return json_decode($e->getResponse()->getBody()->getContents());
        }
    }
}
