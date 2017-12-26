<?php

namespace App\Http\Controllers\admin;

use App\Benchmark;
use App\Http\Controllers\Controller;
use App\User;

class UsersController extends Controller
{
    public function index()
    {
        return view('admin.users.index');
    }

    public function usersJson()
    {
        return datatables()->of(User::query())->toJson();
    }

    public function benchmarksJson($id = null)
    {
        if (is_null($id)) {
            return view('admin.modals.benchmarks');
        }
        $benchmarks = Benchmark::where('user_id', $id)->with('accounts');

        return datatables()->eloquent($benchmarks)->toJson();
    }
}
