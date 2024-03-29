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
    public $engagment;
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
    public function createCharts($days_en = 1, $days_in = 1)
    {

        $charts = config('utils.charts');
        $i = 1;
        $j = 1;
        foreach ($charts as $chart) {
            $this->charts[$i][] = $this->buildBarChart($chart, 'bar');
            if (2 == $j) {
                $i++;
            }
            $j++;
        }

        $this->charts[$i][] = $this->postsNumberChart('pie');
        //$this->charts[$i][] = $this->postsAvreageChart('pie');
        $this->charts[$i][] = $this->totalInteractionsType('grouped_bar');
        $i++;
        $this->charts[$i][] = $this->EngagmentChart('line', $days_en);
        $this->charts[$i][] = $this->InteractionProgressionChart('line', $days_in);
    }

    /**
     * @param $data chart data (to be created)
     * @return array
     */
    public function buildBarChart($data, $type)
    {

        $chart = new Chart;
        if (!isset($data['id'])) {
            $data['id'] = str_random(5);
        }
        $chart->type = $type;
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
    public function postsNumberChart($type)
    {
        $chart = new Chart;

        $data['id'] = str_random(5);

        $chart->type = $type;
        $chart->id = 'canvas-' . $data['id'];
        $chart->title_en = 'Total posts number';
        if ($chart->title_en) {
            $chart->title = 'Total posts number';
        }
        $chart->label = 'Total posts number';

        $count = [];
        foreach ($this->accounts as $key => $account) {
            $chart->data[] = $account->posts->value;
            $chart->labels[] = str_limit($account->social_account_name->title, 15);
        }

        $data = collect($chart->data);
        $chart->total = $data->sum();
        $chart->avg = $data->avg();

        return (array) $chart;
    }

    // Pie chart for avreage posts per page in the defined periode of time
    public function postsAvreageChart($type)
    {
        $chart = new Chart;
        $data['id'] = str_random(5);

        $chart->type = $type;
        $chart->id = 'canvas-' . $data['id'];
        $chart->title_en = 'Average daily posts';
        if ($chart->title_en) {
            $chart->title = 'Average daily posts';
        }
        $chart->label = 'Average daily posts';

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
    public function totalInteractionsType($type)
    {
        $chart = new Chart;

        $data['id'] = str_random(5);

        $chart->type = $type;
        $chart->id = 'canvas-' . $data['id'];
        $chart->title_en = 'Total Interactions';
        if ($chart->title_en) {
            $chart->title = 'Total Interactions';
        }
        $chart->label = 'Total Interactions';

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
    public function InteractionProgressionChart($type, $days = 1)
    {
        $chart = new Chart;
        $data['id'] = 'interactions';
        $chart->id = 'canvas-' . $data['id'];
        $chart->class = 'col-md-12';
        $chart->type = $type;
        $chart->title_en = 'Interactions';
        if ($chart->title_en) {
            $chart->title = 'Interactions';
        }
        $chart->label = 'Interactions';

        $diff = ($this->details->since->diffInDays($this->details->until) / 2);

        $chartData = $this->getInteractionsData($days);

        $chart->labels = $chartData['lables'];
        $chart->data = $chartData['output'];
        $chart->aspect = true;

        return (array) $chart;
    }

    // Generates a line chart data for interaction progress
    // for the future will add yearly data & monthly
    public function getInteractionsData($days = 1)
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
            if (1 == $days) {
                $time->addDay();
            } elseif (7 == $days) {
                $time->addWeek();
            } else {
                $time->addMonth();
            }
        } while ($time->lte($this->details->until));

        $sum = 0;

        foreach ($accounts as $key => $account) {
            $temp_data = $data->{$account};

            $acc_stats = [];
            foreach ($temp_data as $en_date => $el) {
                $sum += $el->sum;
                if (in_array($en_date, $lables)) {
                    $acc_stats[] = number_format($sum, 3, '.', '');
                    $sum = 0;
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

    public function EngagmentChart($type, $days)
    {
        $chart = new Chart;
        $data['id'] = 'engagment';
        $chart->id = 'canvas-' . $data['id'];
        $chart->type = $type;
        $chart->class = 'col-md-12';
        $chart->title_en = 'Page ENgagment';
        if ($chart->title_en) {
            $chart->title = 'Page ENgagment';
        }
        $chart->label = 'Page ENgagment';

        $diff = ($this->details->since->diffInDays($this->details->until) / 2);

        $chartData = $this->getEngagementData($days);

        $chart->labels = $chartData['lables'];
        $chart->data = $chartData['output'];
        $chart->aspect = true;

        return (array) $chart;
    }

    public function getEngagementData($days = 1)
    {
        $accounts = array_keys((array) $this->interactions);

        $full_accounts = json_decode(json_encode($this->accounts), true);

        $colors = config('utils.colors');

        $lables = [];
        $time = $this->details->since->copy();

        $output = [];
        do {
            $lables[] = $time->toDateString();
            if (1 == $days) {
                $time->addDay();
            } elseif (7 == $days) {
                $time->addWeek();
            } else {
                $time->addMonth();
            }
        } while ($time->lte($this->details->until));

        foreach ($accounts as $key => $account) {
            $engagment = $this->engagment->{$account};

            $sum = 0;
            $acc_stats = [];
            foreach ($engagment as $en_date => $eng) {
                if (is_null($eng)) {
                    $eng = 0;
                }

                $sum += $eng;

                if (in_array($en_date, $lables)) {
                    $acc_stats[] = number_format($sum, 3, '.', '');
                    $sum = 0;
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

        $response = $api->get(env('CORE2') . '/rest/insights/' . $id, $params);
        if (!isset($response->data)) {
            return [];
        }
        return head($response->data);
    }
}
