<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserDetails extends Model
{
    protected $table = 'user_details';

    protected $fillable = [
        'user_id', 'phone', 'country', 'city', 'zip', 'address', 'address2',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

}
