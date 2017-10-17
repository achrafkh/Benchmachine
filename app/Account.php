<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Account extends Model
{
    protected $fillable = [
        'remote_id', 'real_id', 'benchmark_id',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [

    ];

    public function benchmark()
    {
        return $this->belongsTo(Benchmark::class);
    }
}
