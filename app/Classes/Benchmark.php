<?php

namespace App\Classes;

use App\Classes\Chart;

/**
 * Class Benchmark
 * @package App\Classes
 */
class Benchmark
{
    public $details;
    public $averages;
    public $variations;
    public $sum;
    public $accounts;
    public $posts;
    public $charts = [];

    public function setAverages($averages)
    {
        $this->averages = $averages;
    }

    public function setSum($sum)
    {
        $this->sum = $sum;
    }

    public function setAccounts($accounts)
    {
        $this->accounts = (isCollection($accounts) ? $accounts : collect($accounts));
    }

    public function setPosts($posts)
    {
        $this->posts = (isCollection($posts) ? $posts : collect($posts));
    }

    public function setVariations($variations)
    {
        $this->variations = $variations;
        if (!isset($this->averages->posts) || 0 == $this->averages->posts) {
            $this->averages->post_interactions_avg = 0;
            $this->variations->averages->post_interactions_avg = json_decode(json_encode(calcVariation(0, 0)));
            return;
        }
        $this->averages->post_interactions_avg = $this->averages->interactions / $this->averages->posts;
        // for cleanup
        $newv =
            (('1.0' . str_replace('.', '', $this->variations->averages->interactions->prct)) * $this->averages->interactions) /
            (('1.0' . str_replace('.', '', $this->variations->averages->posts->prct)) * $this->averages->posts);

        $this->variations->averages->post_interactions_avg = json_decode(json_encode(calcVariation($this->averages->post_interactions_avg, $newv)));
    }

    /**
     * loop and create charts
     */
    public function createCharts()
    {
        $charts = config('utils.charts');

        foreach ($charts as $chart) {
            $this->charts[] = $this->buildBarChart($chart);
        }
    }

    /**
     * @param $data chart data (to be created)
     * @return array
     */
    public function buildBarChart($data)
    {
        $chart = new Chart;
        if (!isset($data['id'])) {
            $data['id'] = str_random(5);
        }
        $chart->id = 'canvas-' . $data['id'];
        $chart->title_en = $data['title_en'];
        if ($chart->title_en) {
            $chart->title = $data['title'];
        }
        $chart->label = $data['label'];

        foreach ($this->accounts as $id => $account) {
            $chart->data[] = $account->{$data['field']}->value;
            $chart->labels[] = str_limit($account->social_account_name->title, 15);
        }

        return (array) $chart;
    }
}
