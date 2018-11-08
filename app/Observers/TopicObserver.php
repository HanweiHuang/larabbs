<?php

namespace App\Observers;

use App\Handlers\SlugTranslateHandler;
use App\Models\Topic;

// creating, created, updating, updated, saving,
// saved,  deleting, deleted, restoring, restored

class TopicObserver
{
    public function creating(Topic $topic)
    {
        //
    }

    public function updating(Topic $topic)
    {
        //
    }

    /**
     * @param Topic $topic
     * will be toggled when saving, make excerpt by topic content
     * Observer, will toggle when save data into database
     */
    public function saving(Topic $topic)
    {
        $topic->body = clean($topic->body, 'user_topic_body');

        $topic->excerpt = make_excerpt($topic->body);

        if(!$topic->slug){
            $topic->slug = app(SlugTranslateHandler::class)->translate($topic->title);
        }
    }
}