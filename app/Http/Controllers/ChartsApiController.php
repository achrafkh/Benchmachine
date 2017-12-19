<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;

class ChartsApiController extends Controller
{
    public function engagmentData(Request $request)
    {
        ini_set('memory_limit', '512M');
        $days = $request->periode;

        $original_bench = $request->benchmark;
        $since = $original_bench['details']['since']['date'];
        unset($original_bench['details']['since']);
        $until = $original_bench['details']['until']['date'];
        unset($original_bench['details']['until']);
        $original_bench['details']['until'] = '';
        $original_bench['details']['since'] = '';
        $original_bench = json_decode(json_encode($original_bench));

        $original_bench->details->since = Carbon::parse($since);
        $original_bench->details->until = Carbon::parse($until);

        $accounts = array_keys((array) $original_bench->interactions);

        $full_accounts = json_decode(json_encode($original_bench->accounts), true);

        $colors = config('utils.colors');

        $lables = [];
        $time = $original_bench->details->since->copy();

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
        } while ($time->lte($original_bench->details->until));

        foreach ($accounts as $key => $account) {
            $engagment = $this->getEngagment($account, $original_bench->details->since->toDateString(), $original_bench->details->until->toDateString());

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
            $test[] = $acc_stats;
            $element = [];
            $element['data'] = $acc_stats;
            $element['label'] = $full_accounts[$account]['social_account_name']['title'];
            $element['backgroundColor'] = $colors[$key];
            $element['borderColor'] = $colors[$key];

            $element['fill'] = false;
            $element['yAxisID'] = 'y-axis-1';

            $output[] = $element;
        }

        return response()->json(compact('output', 'lables'));
    }

    public function getEngagment($id, $since, $until)
    {

        $api = new \App\Acme\Wrapers\ApiAdapter;

        $params['access-token'] = env('CLIENT_TOKEN');
        $params['user-id'] = env('USER_ID');
        $params['insights'] = 'average_page_engagement';
        $params['since'] = $since;
        $params['until'] = $until;

        $response = $api->get(env('CORE') . '/rest/insights/' . $id, $params);
        if (!isset($response->data)) {
            return [];
        }
        return head($response->data);
    }

    public function interactionsData(Request $request)
    {
        ini_set('memory_limit', '512M');
        $days = $request->periode;

        $original_bench = $request->benchmark;

        $since = $original_bench['details']['since']['date'];
        unset($original_bench['details']['since']);
        $until = $original_bench['details']['until']['date'];
        unset($original_bench['details']['until']);
        $original_bench['details']['until'] = '';
        $original_bench['details']['since'] = '';

        $original_bench = json_decode(json_encode($original_bench));

        $original_bench->details->since = Carbon::parse($since);
        $original_bench->details->until = Carbon::parse($until);

        $data = $original_bench->interactions;
        $colors = config('utils.colors');

        $accounts = array_keys((array) $data);
        $full_accounts = json_decode(json_encode($original_bench->accounts), true);
        $lables = [];

        $time = $original_bench->details->since->copy();

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
        } while ($time->lte($original_bench->details->until));

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
        return response()->json(compact('output', 'lables'));
    }
}
