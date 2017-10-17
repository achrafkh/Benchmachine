<?php

namespace App\Acme;

use GuzzleHttp\Client;

class Api
{
    protected $client;

    public function __construct()
    {
        $this->client = new Client(['base_uri' => 'http://api.kpeiz.digital/rest/']);
    }

    public function _get($call, $params = [], $headers = [], $method = 'GET')
    {
        try {
            return json_decode($this
                    ->client
                    ->request($method, $call, ['query' => array_merge($headers, $params)])->getBody()->getContents());

        } catch (\Exception $e) {
            return json_decode($e->getResponse()->getBody()->getContents());
        }
    }
}
