<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Spatie\Permission\Traits\HasRoles;
use Auth;

class User extends Authenticatable
{
    //provide by Spatie\Permission
    use HasRoles;

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


    //clear read record
    public function markAsRead(){
        //user has a field called notification_count in database for recording unread notifications
        $this -> notification_count = 0;
        $this -> save();
        //unreadNotifications comes from HasDatabaseNotifications.php which was included by Notifiable.
        //return Model of DatabaseNotification, this model is defined by laraval notification mechanism
        //this model has a function called markasread which use to set a value for read_at
        $this -> unreadNotifications -> markAsRead();
    }



}