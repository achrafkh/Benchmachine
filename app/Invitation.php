<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Invitation extends Model
{
    use SoftDeletes;

    protected $primaryKey = 'id';
    public $incrementing = false;

    protected $fillable = [
        'id', 'user_id', 'invited_id', 'invited_email', 'type', 'max', 'used_at',
    ];

    public function sender()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function reciever()
    {
        return $this->belongsTo(User::class, 'invited_id');
    }
}
