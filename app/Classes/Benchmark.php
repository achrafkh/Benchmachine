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

    //Process data from last months and set them to this isntance
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
     * Create Charts (add data to charts property)
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

        $this->charts['line'][] = $this->EngagmentChart();
        $this->charts['line'][] = $this->InteractionProgressionChart();
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

        $data = collect($chart->data);
        $chart->total = $data->sum();
        $chart->avg = $data->avg();

        return (array) $chart;
    }

    // Pie chart for posts number in the defined periode of time
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

        $data = collect($chart->data);
        $chart->total = $data->sum();
        $chart->avg = $data->avg();

        return (array) $chart;
    }

    // Pie chart for avreage posts per page in the defined periode of time
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

    // bar chart for Interactions by type(likes comments & shares) for all pages in the defined periode of time
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

    // Line chart for total Interactions in the defined periode of time
    public function InteractionProgressionChart()
    {
        $chart = new Chart;
        $data['id'] = 'large_line';
        $chart->id = 'canvas-' . $data['id'];
        $chart->class = 'col-md-12';
        $chart->title_en = 'Interactions';
        if ($chart->title_en) {
            $chart->title = 'Interactions';
        }
        $chart->label = 'Interactions';

        $diff = ($this->details->since->diffInDays($this->details->until) / 2);

        if ($diff < 30) {
            $chartData = $this->getInteractionsByDays();
        } elseif ($diff < 60) {
            $chartData = $this->getInteractionsByDays();
        } else {
            $chartData = $this->getInteractionsByDays();
        }

        $chart->labels = $chartData['lables'];
        $chart->data = $chartData['output'];
        $chart->aspect = true;

        return (array) $chart;
    }

    // Generates a line chart data for interaction progress
    // for the future will add yearly data & monthly
    public function getInteractionsByDays()
    {
        $data = $this->interactions;
        $colors = config('utils.colors');

        $accounts = array_keys((array) $data);
        $full_accounts = json_decode(json_encode($this->accounts), true);
        $lables = [];
        $time = $this->details->since->copy();

        $output = [];
        do {
            $lables[] = $time->toDateString();
            $time->addDays(1);
        } while ($time->lte($this->details->until));
        foreach ($accounts as $key => $account) {
            $acc_stats = [];
            foreach ($lables as $date) {
                if (isset($data->{$account}->{$date})) {
                    $acc_stats[] = $data->{$account}->{$date}->sum;
                } else {
                    $acc_stats[] = 0;
                }
            }
            $element = [];
            $element['data'] = $acc_stats;
            $element['label'] = $full_accounts[$account]['social_account_name']['title'];
            $element['backgroundColor'] = $colors[$key];
            $element['borderColor'] = $colors[$key];

            $element['fill'] = false;
            $element['yAxisID'] = 'y-axis-1';

            $output[] = $element;
        }
        return compact('output', 'lables');
    }

    public function EngagmentChart()
    {
        $chart = new Chart;
        $data['id'] = str_random(5);
        $chart->id = 'canvas-' . $data['id'];
        $chart->class = 'col-md-6';
        $chart->title_en = 'Page ENgagment';
        if ($chart->title_en) {
            $chart->title = 'Page ENgagment';
        }
        $chart->label = 'Page ENgagment';

        $diff = ($this->details->since->diffInDays($this->details->until) / 2);

        if ($diff < 30) {
            $chartData = $this->getEngagementByDays();
        } elseif ($diff < 60) {
            $chartData = $this->getEngagementByDays();
        } else {
            $chartData = $this->getEngagementByDays();
        }

        $chart->labels = $chartData['lables'];
        $chart->data = $chartData['output'];
        $chart->aspect = true;

        return (array) $chart;
    }

    public function getEngagementByDays()
    {
        $accounts = array_keys((array) $this->interactions);

        $full_accounts = json_decode(json_encode($this->accounts), true);

        $colors = config('utils.colors');

        $lables = [];
        $time = $this->details->since->copy();

        $output = [];
        do {
            $lables[] = $time->toDateString();
            $time->addDays(1);
        } while ($time->lte($this->details->until));

        foreach ($accounts as $key => $account) {
            $engagment = $this->getEngagment($account);

            $acc_stats = [];
            foreach ($lables as $date) {
                if (!is_null($engagment->{$date})) {
                    $acc_stats[] = number_format($engagment->{$date}, 3, '.', '');
                } else {
                    $acc_stats[] = 0;
                }
            }

            $element = [];
            $element['data'] = $acc_stats;
            $element['label'] = $full_accounts[$account]['social_account_name']['title'];
            $element['backgroundColor'] = $colors[$key];
            $element['borderColor'] = $colors[$key];

            $element['fill'] = false;
            $element['yAxisID'] = 'y-axis-1';

            $output[] = $element;
        }

        return compact('output', 'lables');
    }

    // Get engagment for all pages for certain periode from kpeiz core
    public function getEngagment($id)
    {
        $api = new \App\Acme\Wrapers\ApiAdapter;

        $params['access-token'] = env('CLIENT_TOKEN');
        $params['user-id'] = env('USER_ID');
        $params['insights'] = 'average_page_engagement';
        $params['since'] = $this->details->since->toDateString();
        $params['until'] = $this->details->until->toDateString();

        $response = $api->get(env('CORE') . '/rest/insights/' . $id, $params);
        if (!isset($response->data)) {
            return [];
        }
        return head($response->data);
    }
}
