<?php

namespace App\Observers;

use App\Models\Reply;
use App\Notifications\TopicReplied;

// creating, created, updating, updated, saving,
// saved,  deleting, deleted, restoring, restored

class ReplyObserver
{
    public function created(Reply $reply)
    {
        //when we get a reply
        $topic = $reply->topic;
        //let topic table reply_count field add 1
        $reply->topic->increment('reply_count',1);
        //let user table add one notification record
        $topic->user->notify(new TopicReplied($reply));
    }

    public function creating(Reply $reply){
        $reply->content = clean($reply->content,'user_topic_body');
    }

    public function updating(Reply $reply)
    {
        //
    }
}