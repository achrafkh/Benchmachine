<?php

namespace App\Acme\Wrapers;

use App\Acme\Wrapers\DAO;
use App\Classes\Benchmark;
use StdClass;

class Utils
{
    protected $api;

    public function __construct(DAO $api)
    {
        $this->api = $api;
    }

    public function getBenchmark($id)
    {

        $response = $this->api->getBenchmarkById($id);

        return $this->prepareBenchmark($response->data);
    }

    public function prepareBenchmark($data)
    {
        $benchmark = new Benchmark;

        $posts = $this->mapPost($data->most_engaged_posts)->sortByDesc('engagement_rate');
        unset($data->most_engaged_posts);

        $benchmark->setposts($posts);
        $benchmark->details = $data->details;

        unset($data->details);

        $accounts = collect($data);
        $benchmark->setAccounts($accounts);

        $keys = config('helpers.averages');
        $sum_keys = config('helpers.sum');

        $averages = new StdClass;
        $sum = new StdClass;
        foreach ($keys as $key) {
            $averages->{$key} = $accounts->avg($key . '.value');

            if (in_array($key, $sum_keys)) {
                $sum->{$key} = $accounts->sum($key . '.value');
            }
        }

        $benchmark->setaverages($averages);
        $benchmark->setSum($sum);

        return $benchmark;
    }

    public function mapPost($posts)
    {

        return collect($posts)->map(function ($post) {

            if (is_array($post)) {
                $ints = json_decode($post['interactions'], true);
                $post['likes'] = $ints['facebook::likes'];
                $post['shares'] = $ints['facebook::shares'];
                $post['comments'] = $ints['facebook::comments'];
                $post['total_interactions'] = ($post['likes'] + $post['shares'] + $post['comments']);
            } else {
                $ints = json_decode($post->interactions, true);
                $post->likes = $ints['facebook::likes'];
                $post->shares = $ints['facebook::shares'];
                $post->comments = $ints['facebook::comments'];
                $post->total_interactions = ($post->likes + $post->shares + $post->comments);
            }

            return $post;
        });
    }
};
