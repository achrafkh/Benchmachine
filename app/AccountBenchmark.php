<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AccountBenchmark extends Model
{
    public $incrementing = false;

    protected $table = 'account_benchmark';

    protected $fillable = [
        'account_id', 'benchmark_id',
    ];
}
