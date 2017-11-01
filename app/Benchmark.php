<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Benchmark extends Model
{
    protected $fillable = [
        'title', 'since', 'until', 'user_id', 'status', 'temp_id',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [

    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function order()
    {
        return $this->hasOne(Order::class);
    }

    public function updateStatus($status)
    {
        $this->status = $status;
        $this->save();
    }

    public function accounts()
    {
        return $this->belongsToMany(Account::class, 'account_benchmark')->withTimestamps();
    }

    public function updateTitle($title)
    {
        if ($title == $this->title && trim($title) == '') {
            return true;
        }
        $this->title = $title;
        return $this->save();
    }

    public function markAsReady()
    {
        $this->status = 2;
        return $this->save();
    }

    public function getStatus()
    {
        if (1 == $this->status) {
            return ['class' => 'info', 'text' => 'Processing'];
        } elseif (2 == $this->status) {
            return ['class' => 'success', 'text' => 'Ready'];
        }
        return ['class' => 'warning', 'text' => 'Unpaid'];
    }
}
