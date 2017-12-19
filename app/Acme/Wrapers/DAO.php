<?php

namespace App\Acme\Wrapers;

use App\Account;
use App\Acme\Wrapers\ApiAdapter;
use App\Benchmark;
use Cache;
use Carbon\Carbon;
use DB;
use StdClass;
use Storage;

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
        if (Storage::has('cache/benchmarks/benchmark-' . $id . '.json')) {
            return json_decode(Storage::get('cache/benchmarks/benchmark-' . $id . '.json'));
        }
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

        $engagment = new Stdclass;
        foreach ($pages_ids as $id2) {
            $engagment->{$id2} = getEngagment($id2, $benchmark->since, $benchmark->until);
        }
        $data->data->engagment = $engagment;

        Storage::put('cache/benchmarks/benchmark-' . $id . '.json', json_encode($data));

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

        $data = $this->getBenchmarkByPagesIds($ids, $since->toDateString(), $until->toDateString(), false);

        return $data->data;
    }

    /**
     * Retrieve Benchmark data From kpeiz Core using Accounts ids & date range
     * @param $ids
     * @param $since
     * @param $until
     * @return \Illuminate\Http\Response
     */
    public function getBenchmarkByPagesIds($ids, $since, $until, $posts = true)
    {
        if (is_array($ids)) {
            $ids = implode(',', $ids);
        }

        $cacheId = getCacheId($ids, $since, $until, $posts);

        $params = [
            'since' => $since,
            'until' => $until,
            'posts' => $posts,
            'social-accounts' => $ids,
        ];

        return Cache::remember('corebench-' . $cacheId, env('CACHE_TIME'), function () use ($params) {
            return $this->api->post('custom-benchmark', $params);
        });
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
        $toBeDeleted = [];
        foreach ($pages as $key => $url) {
            if (null == $url) {
                continue;
            }
            $response = $this->api->get('account/facebook', ['input' => $url]);

            if (is_null($response) || 500 == $response->status) {
                $errors['error'] = true;
                $errors['pages'][] = $url;
                continue;
            }

            if (!$response->data->exits) {
                $exists = DB::table('new_pages')->where('page_id', $response->data->social_account_id)->exists();

                if (!$exists) {
                    DB::table('new_pages')->insert(
                        [
                            'page_id' => $response->data->social_account_id,
                            'created_at' => Carbon::now(),
                            'updated_at' => Carbon::now(),
                        ]
                    );
                }
            }

            $account = new Account;
            $account->id = $response->data->social_account_id;
            $account->real_id = $response->data->social_account_real_id;
            $account->image = $response->data->social_account_picture;
            $account->label = $response->data->social_account_label;
            $account->title = $response->data->social_account_title;

            if (!$response->data->exits) {
                $status = 0;
            }

            $account_ids->push($account);
        }
        if ($errors['error']) {
            return $errors;
        }

        return compact('status', 'account_ids');
    }

    public function fetchDataForBenchmark($benchmark_id)
    {
        $benchmark = Benchmark::with('accounts')->find($benchmark_id);

        $this->api->post('init-machine', [
            'account_ids' => $benchmark->accounts->pluck('id')->toarray(),
            'since' => $benchmark->since,
            'until' => $benchmark->until,
        ]);
        // $this->api->post('add-custom-tag', [
        //     'account_ids' => $benchmark->accounts->pluck('id')->toarray(),
        //     'tag' => config('utils.tag'),
        // ]);
    }

    public function createBenchmark($accounts)
    {
        $response = $this->addPages($accounts, $token);

        $pages = $response['account_ids'];
        $status = $response['status'];

        return $benchmark;
    }

    /**
     * Create abenchmark for current authenticated user
     * @param Array $accounts Account links
     * @param string $since Start date
     * @param string $until End date
     * @param string $title Benchmark title
     * @return App\Benchmark model
     */
    public function prepareBenchmark($accounts, $since, $until, $title = 'My Benchmark', $user_id = null)
    {
        // Add pages to kpeiz core to collect dat
        $token = str_random(40);
        $status = 1;

        // temp_id is uselss for now, might be usefull later
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
