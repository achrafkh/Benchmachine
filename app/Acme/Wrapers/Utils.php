<?php

namespace App\Acme\Wrapers;

use App\Acme\Wrapers\DAO;
use App\Benchmark as Benchi;
use App\Classes\Benchmark;
use StdClass;

class Utils
{
    protected $api;

    public function __construct(DAO $api)
    {
        $this->api = $api;
    }

    public function getBenchmark($id, $days = 1)
    {

        $response = $this->api->getBenchmarkById($id);

        return $this->prepareBenchmark($response->data, $days);
    }

    public function getBenchmarkHtml($id, $print = false, $data = [])
    {
        if ($print) {
            $file = public_path() . '/static/app/benchmark-' . $id . '_print.html';
        } else {
            $file = public_path() . '/static/app/benchmark-' . $id . '.html';
        }
        if (!file_exists($file)) {
            if (isset($data['date'])) {
                $days = $data['date'];
            } else {
                $days = 1;
            }
            $benchmark = $this->getBenchmark($id, $days);

            $static = true;

            $html_print = view('facebook.benchmark_print', compact('benchmark', 'static', 'print'))->render();

            file_put_contents(public_path() . '/static/app/benchmark-' . $id . '_print.html', replace($html_print));

            if (!$print) {
                $html = view('facebook.benchmark', compact('benchmark', 'static'))->render();
                file_put_contents(public_path() . '/static/app/benchmark-' . $id . '.html', replace($html));
            }
        } else {
            if ($print) {
                $html_print = file_get_contents($file);
            } else {
                $html = file_get_contents($file);
            }
        }
        if ($print) {
            return $html_print;
        }
        return $html;
    }

    /**
     * Get Benchmark data and map them to Benchmark object
     * Sum/set values
     * @param Stdclass $data Benchmark data
     * @return App\Classes\Benchmark instance
     */
    public function prepareBenchmark($data, $days = 1)
    {

        $benchmark = new Benchmark;

        $posts = $this->mapPost($data->most_engaged_posts)->sortByDesc('engagement_rate');
        unset($data->most_engaged_posts);

        $benchmark->setposts($posts);
        $benchmark->details = $data->details;

        unset($data->details);

        $interactions = $data->interactions;
        $benchmark->setInteractions($interactions);
        unset($data->interactions);

        $old_accounts = collect($data->old);
        unset($data->old);

        $accounts = collect($data);
        $benchmark->setAccounts($accounts);

        $benchmark->createCharts($days);

        $summary = $this->getSummary($accounts);
        $old_summary = $this->getSummary($old_accounts);

        $benchmark->setAverages($summary['averages']);
        $benchmark->setSum($summary['sum']);

        $variations = $this->calculateVariation((array) $old_summary, (array) $summary);
        $benchmark->setVariations($variations);

        return $benchmark;
    }

    public function calculateVariation($old, $new)
    {
        $variations = [];

        foreach ($new as $key => $value) {
            foreach ($value as $index => $val) {
                $variations[$key][$index] = calcVariation($old[$key]->{$index}, $val);
            }
        }
        return json_decode(json_encode($variations));
    }

    public function getSummary($accounts)
    {
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

        return compact('averages', 'sum');
    }

    /**
     * Get An array of posts and map interactions
     * @param Array $posts Posts Array
     * @return Illuminate\Support\Collection instance
     */
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

    /**
     * Check if data is ready for a certain benchmark
     * @param App\Benchmark $benchmark Get benchmark isntance
     * @return bool
     */
    public function benchmarkIsReady(Benchi $benchmark)
    {
        // if accounts are not already loaded load them
        if (null == $benchmark->accounts) {
            $benchmark->load('accounts');
        }
        // get accounts ids in an array
        $page_ids = $benchmark->accounts->pluck('id')->toarray();

        // check if data is collected for this pages
        $response = $this->api->dataAvailable($page_ids);

        //if ready return true
        if (isset($response->ready) && $response->ready) {
            return true;
        }
        return false;
    }
};
