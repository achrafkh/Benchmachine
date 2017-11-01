<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    public $incrementing = false;

    protected $fillable = [
        'id', 'total', 'status', 'benchmark_id', 'user_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function benchmark()
    {
        return $this->belongsTo(Benchmark::class);
    }
}
