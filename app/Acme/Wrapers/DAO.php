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

    public function __construct(ApiAdapter $api)
    {
        $this->api = $api;
    }

    public function getBenchmarkById($id)
    {
        $benchmark = Benchmark::with('accounts')->find($id);
        if (!$benchmark) {
            return null;
        }
        $pages_ids = $benchmark->accounts->pluck('remote_id')->toarray();

        $data = $this->getBenchmarkByPagesIds($pages_ids, $benchmark->since, $benchmark->until);

        if (isset($data->data)) {
            $details = new StdClass;
            $details->title = $benchmark->title;
            $details->since = Carbon::parse($benchmark->since);
            $details->until = Carbon::parse($benchmark->until);

            $data->data->details = $details;
        }
        return $data;
    }

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
            $account->remote_id = $response->data->social_account_id;
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
                'account_ids' => $account_ids->pluck('remote_id')->toarray(),
                'bench_temp_id' => $token,
            ]);
        }

        return compact('status', 'account_ids');
    }
}
