<?php

namespace App;

use App\UserDetails;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'provider', 'provider_id', 'token',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $appends = ['image'];

    public function getImageAttribute()
    {
        return 'http://graph.facebook.com/' . $this->provider_id . '/picture';
    }

    public function benchmarks()
    {
        return $this->hasMany(Benchmark::class);
    }

    public function details()
    {
        return $this->hasOne(UserDetails::class);
    }

    public function hasDetails()
    {
        if (!$this->details) {
            return false;
        }
        $bool = $this->details()->whereNotNull('phone')->where('phone', '<>', '')
            ->whereNotNull('country')->where('country', '<>', '')
            ->whereNotNull('city')->where('city', '<>', '')
            ->whereNotNull('zip')->where('zip', '<>', '')
            ->whereNotNull('email')->where('email', '<>', '')
            ->whereNotNull('address')->exists();

        return $bool;
    }

    public function getPayementDetails()
    {

        if (null == $this->details) {
            $this->load('details');
        }

        $params['phone'] = $this->details->phone;
        $params['email'] = $this->details->email;
        $params['user_id'] = $this->id;
        $params['last_name'] = head(explode(' ', $this->name));
        $params['first_name'] = last(explode(' ', $this->name));
        $params['address'] = $this->details->address;
        $params['zip_code'] = $this->details->zip;
        $params['city'] = $this->details->city;
        $params['country'] = $this->details->country;

        return $params;
    }

    public function getValidEmail()
    {
        if (null == $this->details) {
            $this->load('details');
        }
        if (!$this->hasDetails()) {
            return $this->email;
        }

        return $this->details->email;
    }

    public function saveData($data = [])
    {
        $data['user_id'] = $this->id;
        return UserDetails::create($data);
    }
}
