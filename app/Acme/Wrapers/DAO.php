<?php

namespace App\Acme\Wrapers;

use App\Account;
use App\Acme\Wrapers\ApiAdapter;
use App\Benchmark;
use Carbon\Carbon;
use StdClass;

class DAO
{
    protected $api;

    /**
     * DAO constructor.
     * @param \App\Acme\Wrapers\ApiAdapter $api
     */
    public function __construct(ApiAdapter $api)
    {
        $this->api = $api;
    }

    /**
     * Retrieve Benchmark data From kpeiz Core using a benchmark id
     * @param Integer $id Benchmark id
     * @return stdclass Benchmark data
     */
    public function getBenchmarkById($id)
    {
        $benchmark = Benchmark::with('accounts')->find($id);
        if (!$benchmark) {
            return null;
        }
        $pages_ids = $benchmark->accounts->pluck('id')->toarray();

        $data = $this->getBenchmarkByPagesIds($pages_ids, $benchmark->since, $benchmark->until);

        $vars = $this->getVariations($pages_ids, $benchmark->since, $benchmark->until);

        $data->data->old = $vars;

        if (isset($data->data)) {
            $details = new StdClass;
            $details->id = $benchmark->id;
            $details->title = $benchmark->title;
            $details->since = Carbon::parse($benchmark->since);
            $details->until = Carbon::parse($benchmark->until);

            $data->data->details = $details;
        }

        return $data;
    }

    /**
     * @param $ids
     * @param $since
     * @param $until
     * @return mixed
     */
    public function getVariations($ids, $since, $until)
    {

        $until = Carbon::parse($until);
        $since = Carbon::parse($since);

        $difference = $until->diffInDays($since);
        $until->subdays($difference);
        $since->subdays($difference);

        $data = $this->getBenchmarkByPagesIds($ids, $since->toDateString(), $until->toDateString());

        unset($data->data->most_engaged_posts);
        return $data->data;
    }

    /**
     * Retrieve Benchmark data From kpeiz Core using Accounts ids & date range
     * @param $ids
     * @param $since
     * @param $until
     * @return \Illuminate\Http\Response
     */
    public function getBenchmarkByPagesIds($ids, $since, $until)
    {
        if (is_array($ids)) {
            $ids = implode(',', $ids);
        }

        $params = [
            'since' => $since,
            'until' => $until,
            'social-accounts' => $ids,
        ];
        return $this->api->post('custom-benchmark', $params);
    }

    /**
     * Addes pages to kpeiz core
     * token is used to notify the client after kpeiz core is done collecting data
     * @param Array $pages Pages Links
     * @param string $token benchmark temporary identifier
     * @return Array account_ids & status (CZ Pages migh be already ready in kpeiz core)
     */
    public function addPages($pages = [], $token = null)
    {
        $account_ids = collect([]);
        $errors['error'] = false;
        $status = 1;
        foreach ($pages as $url) {
            if (null == $url) {
                continue;
            }
            $response = $this->api->get('account/facebook', ['input' => $url]);

            if (500 == $response->status) {
                $errors['error'] = true;
                $errors['pages'][] = $url;
                continue;
            }

            $account = new Account;
            $account->id = $response->data->social_account_id;
            $account->real_id = $response->data->social_account_real_id;

            if (!$response->data->exits) {
                $status = 0;
            }

            $account_ids->push($account);
        }
        if ($errors['error']) {
            return $errors;
        }
        if ($token) {
            $this->api->post('restore-if-deleted-bench', [
                'account_ids' => $account_ids->pluck('id')->toarray(),
                'bench_temp_id' => $token,
            ]);
            $this->api->post('add-custom-tag', [
                'account_ids' => $account_ids->pluck('id')->toarray(),
                'tag' => config('utils.tag'),
            ]);
        }

        return compact('status', 'account_ids');
    }

    public function fetchDataForBenchmark($benchmark_id)
    {
        $benchmark = Benchmark::with('accounts')->find($benchmark_id);

        $this->api->post('restore-if-deleted-bench', [
            'account_ids' => $benchmark->accounts->pluck('id')->toarray(),
            'bench_temp_id' => $benchmark->temp_id,
        ]);
        $this->api->post('add-custom-tag', [
            'account_ids' => $benchmark->accounts->pluck('id')->toarray(),
            'tag' => config('utils.tag'),
        ]);
    }

    /**
     * Create abenchmark for current authenticated user
     * @param Array $accounts Account links
     * @param string $since Start date
     * @param string $until End date
     * @param string $title Benchmark title
     * @return App\Benchmark model
     */
    public function createBenchmark($accounts)
    {
        $response = $this->addPages($accounts, $token);

        $pages = $response['account_ids'];
        $status = $response['status'];

        return $benchmark;
    }

    public function prepareBenchmark($accounts, $since, $until, $title = 'My Benchmark', $user_id = null)
    {
        // Add pages to kpeiz core to collect dat
        $token = str_random(40);
        $status = 0;
        // the token will be used as a temporary ID to check if collecting data is done
        // when data collecting is done, the benchmark with this token will be marked as ready
        $benchmark = Benchmark::create([
            'user_id' => $user_id,
            'temp_id' => $token,
            'title' => $title,
            'since' => $since,
            'until' => $until,
            'status' => $status,
        ]);

        $benchmark->save();

        $benchmark->accounts()->sync($accounts);

        return $benchmark;
    }

    /**
     * Check if provided pages ids are ready (if core is done collecting data)
     * @param Array $pages_ids Page ids
     * @return Stdclass $response
     */
    public function dataAvailable($pages_ids)
    {
        // check kpeiz core if pages with this ids are ready
        return $this->api->post('pages-available', ['pages_ids' => $pages_ids]);
    }
}
