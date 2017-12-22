<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Storage;

class ChartsApiController extends Controller
{
    public function engagmentData(Request $request)
    {
        $days = $request->periode;
        $original_bench = json_decode(Storage::get('cache/benchmarks/benchmark-' . $request->id . '.json'));

        unset($original_bench->data->old);
        unset($original_bench->data->most_engaged_posts);

        $full_accounts = [];
        foreach ($original_bench->data as $key => $attribute) {
            if ('details' == $key || 'engagment' == $key || 'interactions' == $key) {
                continue;
            }
            $full_accounts[$key] = json_decode(json_encode($attribute), true);
        }

        $since = Carbon::parse(head($original_bench->data->details->since));
        $until = Carbon::parse(head($original_bench->data->details->until));

        $accounts = array_keys((array) $original_bench->data->interactions);

        $colors = config('utils.colors');

        $lables = [];
        $time = $since->copy();

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
        } while ($time->lte($until));

        foreach ($accounts as $key => $account) {
            $engagment = $original_bench->data->engagment->{$account};

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

        $response = $api->get(env('CORE2') . '/rest/insights/' . $id, $params);
        if (!isset($response->data)) {
            return [];
        }
        return head($response->data);
    }

    public function interactionsData(Request $request)
    {

        $days = $request->periode;
        $original_bench = json_decode(Storage::get('cache/benchmarks/benchmark-' . $request->id . '.json'));

        unset($original_bench->data->old);
        unset($original_bench->data->most_engaged_posts);
        $data = $original_bench->data->interactions;
        $full_accounts = [];
        foreach ($original_bench->data as $key => $attribute) {
            if ('details' == $key || 'engagment' == $key || 'interactions' == $key) {
                continue;
            }
            $full_accounts[$key] = json_decode(json_encode($attribute), true);
        }

        $since = Carbon::parse(head($original_bench->data->details->since));
        $until = Carbon::parse(head($original_bench->data->details->until));

        $accounts = array_keys((array) $original_bench->data->interactions);

        $colors = config('utils.colors');

        $lables = [];
        $time = $since->copy();

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
        } while ($time->lte($until));

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
