<?php

namespace App\Observers;

use App\Events\UpdateReply;
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

        //broadcast new reply alert
        $this->broadcastReplyCount($topic);
    }

    public function creating(Reply $reply){
        $reply->content = clean($reply->content,'user_topic_body');
    }

    public function updating(Reply $reply)
    {
        //
    }

    public function deleted(Reply $reply)
    {
        $reply->topic->decrement('reply_count', 1);
    }

    /**
     * @param $topic
     * for broadcast a new reply
     */
    private function broadcastReplyCount($topic){
        if(!config('broadcasting.switch')) return;
        $date = [
            'topic_id' => $topic->id,
            'reply_count' => $topic->reply_count,
        ];
        //broadcast here
        broadcast(new UpdateReply($date));
    }

}