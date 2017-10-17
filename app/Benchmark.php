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

    public function accounts()
    {
        return $this->hasMany(Account::class);
    }

    public function updateTitle($title)
    {
        if ($title == $this->title && trim($title) == '') {
            return true;
        }
        $this->title = $title;
        return $this->save();
    }
}
