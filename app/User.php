<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Library\EaseIM as EaseIM;
use Log;
use App;

class User extends Authenticatable
{
    static function boot()
    {
        parent::boot();
        User::creating(function($user)
        {
            $im = new EaseIM();
            $result = $im->createUser($user->phone, $user->phone);
            Log::info('向环信注册用户');
            Log::info(json_encode($result));
        });
    }
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'phone', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function posts()
    {
        return $this->hasMany('App\Post');
    }

    public function likes()
    {
        return $this->belongsToMany('App\Post', 'likes');
    }

    public function friends()
    {
        return $this->belongsToMany('App\User', 'friends', 'user_id', 'friend_id');
    }

    public function beFriendWith(User $user)
    {
        $this->friends()->save($user);
    }

    public function isFriendOf(User $user)
    {
        if( $user->firends()->pluck('id')->contains($this->id) ) {
            return true;
        }
        return false;
    }

}
