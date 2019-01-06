<?php

namespace App\Models;

class Reply extends Model
{
    protected $fillable = ['content'];

    //one reply belong to one topic
    public function topic(){
        return $this->belongsTo(Topic::class);
    }

    //one reply belong to one user
    public function user(){
        return $this->belongsTo(User::class);
    }
}