<?php

namespace App\Acme\Wrapers;

use App\Acme\Api;
use Cache;

class ApiAdapter extends Api
{
    protected $cache_time;

    public function __construct()
    {
        $this->cache_time = env('CACHE_TIME');
        $this->headers = ['user-id' => env('USER_ID'), 'access-token' => env('CLIENT_TOKEN')];
        parent::__construct();
    }

    public function get($url = '', $params = [], $cache = true)
    {
        return Cache::remember($url . implode('-', $params), $this->cache_time, function () use ($url, $params) {
            return $this->_get($url, $params, $this->headers, 'GET');
        });
    }

    public function post($url = '', $params = [], $cache = true)
    {
        return $this->_get($url, $params, $this->headers, 'POST');
    }

}
