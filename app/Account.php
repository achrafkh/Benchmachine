<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Account extends Model
{
    public $incrementing = false;

    protected $fillable = [
        'id', 'real_id',
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
        return $this->belongsToMany(Benchmark::class, 'account_benchmark')->withTimestamps();
    }
}
