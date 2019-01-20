<?php

namespace App\Models\Traits;

use Redis;
use Carbon\Carbon;

trait LastActivedAtHelper{

    protected $hash_prefix = 'larabbs_last_actived_at';
    protected $field_prefix = 'user_';

    //record actived time to redis
    public function recordLastActivedAt(){

        //get today date
        $date = Carbon::now()->toDateString();

        $hash = $this->hash_prefix . $date;
        $field = $this->field_prefix . $this->id;

        //dd(Redis::hGetAll($hash));

        //save current time
        $now = Carbon::now()->toDateTimeString();

        Redis::hSet($hash, $field, $now);
    }

    public function syncUserActivedAt(){

        $yesterday_date = Carbon::yesterday()->toDateString();
        //$today_date = Carbon::now()->toDateString();

        $time_date = $yesterday_date;

        $hash = $this->hash_prefix . $time_date;

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
}