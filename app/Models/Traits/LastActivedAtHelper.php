<?php

namespace App\Models\Traits;

use Redis;
use Carbon\Carbon;

trait LastActivedAtHelper{

    protected $hash_prefix = 'larabbs_last_actived_at';
    protected $field_prefix = 'user_';

    //record actived time to redis
    public function recordLastActivedAt(){

        $hash = $this->getHashFromDateString(Carbon::now()->toDateString());

        $field = $this->getHashField();

        //dd(Redis::hGetAll($hash));

        //save current time
        $now = Carbon::now()->toDateTimeString();

        Redis::hSet($hash, $field, $now);
    }

    //sync from redis to database
    public function syncUserActivedAt(){

        $time_date = Carbon::yesterday()->toDateString();
        //$time_date = Carbon::now()->toDateString();

        $hash = $this->getHashFromDateString($time_date);

        $dates = Redis::hGetAll($hash);

        foreach($dates as $user_id => $actived_at){
            //get id only
            $user_id = str_replace($this->field_prefix, '', $user_id);

            if($user = $this->find($user_id)){
                $user->last_actived_at = $actived_at;
                $user->save();
            }
        }

        //clear yesterday redis date
        Redis::del($hash);
    }




    //
    public function getLastActivedAtAttribute($value){

        $hash = $this->getHashFromDateString(Carbon::now()->toDateString());

        $field = $this->getHashField();

        $datetime = Redis::hGet($hash, $field) ? : $value;

        if($datetime){
            return new Carbon($datetime);
        }else{
            return $this->created_at;
        }
    }



    //help functions
    public function getHashFromDateString($date){
        return $this->hash_prefix . $date;
    }


    public function getHashField(){
        return $this->field_prefix . $this->id;
    }





}