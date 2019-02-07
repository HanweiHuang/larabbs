<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Spatie\Permission\Traits\HasRoles;
use Auth;

class User extends Authenticatable
{

    //traits about last active time
    use Traits\LastActivedAtHelper;

    //traits about active users
    use Traits\ActiveUserHelper;

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
        //return Model of DatabaseNotification, this model is defined by laravel notification mechanism
        //this model has a function called markasread which used to set a value for read_at
        $this -> unreadNotifications -> markAsRead();
    }

    /** this part for administrator */
    //for password format when save to database
    public function setPasswordAttribute($value)
    {
        // 如果值的长度等于 60，即认为是已经做过加密的情况
        if (strlen($value) != 60) {

            // 不等于 60，做密码加密处理
            $value = bcrypt($value);
        }

        $this->attributes['password'] = $value;
    }

    //srt attribute
    public function setAvatarAttribute($path)
    {
        // 如果不是 `http` 子串开头，那就是从后台上传的，需要补全 URL
        if ( ! starts_with($path, 'http')) {

            // 拼接完整的 URL
            $path = config('app.url') . "/uploads/images/avatars/$path";
        }

        $this->attributes['avatar'] = $path;
    }


}