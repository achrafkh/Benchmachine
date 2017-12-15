<?php

namespace App;

use App\Mail\NotifyUser;
use Illuminate\Database\Eloquent\Model;
use Mail;

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
        //
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
        if (ucfirst($title) == $this->title && trim($title) == '') {
            return true;
        }
        $this->title = ucfirst($title);
        return $this->save();
    }

    public function markAsReady($email = null)
    {
        $this->status = 2;
        $bool = $this->save();

        if ($email) {
            $this->SendReadyEmail($email);
        }
        return $bool;
    }

    public function getStatus()
    {
        if (1 == $this->status) {
            return ['class' => 'warning', 'text' => 'Pending'];
        }
        return ['class' => 'success', 'text' => 'Ready'];
    }

    public function SendReadyEmail($email)
    {
        Mail::to($email)
            ->send(new NotifyUser($this));
    }
}
