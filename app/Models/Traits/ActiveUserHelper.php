<?php

namespace App\Models\Traits;

use App\Models\Topic;
use App\Models\Reply;
use Carbon\Carbon;
use Cache;
use DB;

trait ActiveUserHelper{

    //for temperory users
    protected $users = [];

    protected $reply_weight = 1;
    protected $topic_weight = 4;
    protected $pass_days = 57; //how many days need to calculate
    protected $user_number = 6;//how many users we need

    //cache
    protected $cache_key = 'larabbs_active_users';
    protected $cache_expire_in_minutes = '65';

    /* **** Start Public functions   *********
    * provide two public functions:
    *     getActiveUsers
    *     calculateAndCacheActiveUsers // calculate and cache active users
    *
    */
    public function calculateAndCacheActiveUsers(){
        //get active users
        $active_users = $this->calculateActiveUsers();
        //cache active users
        $this->cacheActiveUsers($active_users);
    }

    public function getActiveUsers(){

        return Cache::remember(
            $this->cache_key, $this->cache_expire_in_minutes,
            function(){
                return $this->calculateActiveUsers();
            }
        );
    }

    /******** End public functions***********/

    private function calculateActiveUsers(){
        //after these two functions, the array users should have data
        $this->calculateTopicScore();
        $this->calculateReplyScore();

        //sort array user by score
        $users = array_sort($this->users, function($user){
            return $user['score'];
        });

        //second parameter is keep the same of keys
        $users = array_reverse($users,true);
        $users = array_slice($users,0,$this->user_number, true);

        //return array
        $active_users = collect();
        foreach($users as $user_id => $user){
            //trait get from parent user
            $user = $this->find($user_id);

            if($user){
                $active_users->push($user);
            }
        }

        return $active_users;

    }

    /**
    * calcurate all topic points
    **/
    private function calculateTopicScore(){

        $topic_users = Topic::query()->select(DB::raw('user_id, count(*) as topic_count'))
                                 ->where('created_at','>=', Carbon::now()->subDays($this->pass_days))
                                 ->groupBy('user_id')
                                 ->get();


        foreach($topic_users as $value){
            $this->users[$value->user_id]['score'] = $value->topic_count * $this->topic_weight;
        }
    }


    private function calculateReplyScore(){
        $reply_users = Reply::query()->select(DB::raw('user_id, count(*) as reply_count'))
                                     ->where('created_at', '>=', Carbon::now()->subDays($this->pass_days))
                                     ->groupBy('user_id')
                                     ->get();
        foreach($reply_users as $value){
            $reply_score = $value->reply_count * $this->reply_weight;
            if(isset($this->users[$value->user_id])){
                $this->users[$value->user_id]['score'] += $reply_score;
            }else{
                $this->users[$value->user_id]['score'] = $reply_score;
            }
        }
    }

    private function cacheActiveUsers($active_users){
        Cache::put($this->cache_key, $active_users, $this->cache_expire_in_minutes);
    }
}




?>