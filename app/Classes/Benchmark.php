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
    public $interactions;
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

    public function setInteractions($interactions)
    {
        $this->interactions = $interactions;
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
            $this->charts['bar'][] = $this->buildBarChart($chart);
        }

        $this->charts['pie'][] = $this->postsNumberChart();
        $this->charts['pie'][] = $this->postsAvreageChart();

        $this->charts['grouped_bar'][] = $this->totalInteractionsType();
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

    public function postsNumberChart($data = [])
    {
        $chart = new Chart;
        if (!isset($data['id'])) {
            $data['id'] = str_random(5);
        }
        $chart->id = 'canvas-' . $data['id'];
        $chart->title_en = 'Total Nombre des publication';
        if ($chart->title_en) {
            $chart->title = 'Total Nombre des publication';
        }
        $chart->label = 'Total Nombre des publication';

        $count = [];
        foreach ($this->accounts as $key => $account) {
            $chart->data[] = $this->posts->where('social_post_account', $key)->count();
            $chart->labels[] = str_limit($account->social_account_name->title, 15);
        }

        return (array) $chart;
    }

    public function postsAvreageChart($data = [])
    {
        $chart = new Chart;
        if (!isset($data['id'])) {
            $data['id'] = str_random(5);
        }
        $chart->id = 'canvas-' . $data['id'];
        $chart->title_en = 'Moyene des publication par jour';
        if ($chart->title_en) {
            $chart->title = 'Moyene des publication par jour';
        }
        $chart->label = 'Moyene des publication par jour';

        $count = [];
        foreach ($this->accounts as $key => $account) {
            $posts_count = $this->posts->where('social_post_account', $key)->count();
            $days = $this->details->since->diffInDays($this->details->until);

            $chart->data[] = number_format(($posts_count / $days), 1);
            $chart->labels[] = str_limit($account->social_account_name->title, 15);
        }

        return (array) $chart;
    }

    public function totalInteractionsType($data = [])
    {
        $chart = new Chart;
        if (!isset($data['id'])) {
            $data['id'] = str_random(5);
        }
        $chart->id = 'canvas-' . $data['id'];
        $chart->title_en = 'Total Interactions par type';
        if ($chart->title_en) {
            $chart->title = 'Total Interactions par type';
        }
        $chart->label = 'Total Interactions par type';

        $count = [];

        $stat = ['likes', 'comments', 'shares'];

        $colors = config('utils.colors');

        $details = [];

        foreach ($this->accounts as $key => $account) {
            $chart->labels[] = str_limit($account->social_account_name->title, 15);
            $details['likes'][] = collect($this->interactions->{$key})->sum('likes');
            $details['comments'][] = collect($this->interactions->{$key})->sum('comments');
            $details['shares'][] = collect($this->interactions->{$key})->sum('shares');
        }
        foreach ($stat as $index => $v) {
            $chart->data[] = [
                'label' => $v,
                'backgroundColor' => $colors[$index],
                'data' => $details[$v],
            ];
        }
        return (array) $chart;
    }

    public function InteractionProgressionChart()
    {
        //
    }
}
