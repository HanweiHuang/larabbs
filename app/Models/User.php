<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Auth;

class User extends Authenticatable
{

    //use MustVerifyEmailTrait;

    //class Notifiable also has a function called notify, so rename notify as laravelNotify
    use Notifiable{
        notify as protected laravelNotify;
    }

    public function notify($instance){
        //if current user is the one need to notify, return, don't need to notify
        if($this->id == Auth::id()){
            return;
        }

        $this->increment('notification_count');

        $this->laravelNotify($instance);
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'introduction', 'avatar'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    //one user can have many replies
    public function replies(){
        return $this->hasMany(Reply::class);
    }

    public function topics(){
        return $this->hasMany(Topic::class);
    }

    //authority
    public function isAuthorOf($model){
        return $this->id == $model->user_id;
    }
}