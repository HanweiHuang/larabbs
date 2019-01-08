<?php

namespace App\Observers;

use App\Handlers\SlugTranslateHandler;
use App\Jobs\TranslateSlug;
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

    }

    /**
     * @param Topic $topic
     * queue system only serialize 'id' in terms of the object which was injected in construct function.
     * To saving function, it observes actions when save a data to database but not yet saved in database
     * so, there is no id exist for object currently. so we need to dispatch translate in saved function which
     * the topic has already saved in database, and id of topic exists as well
     */
    public function saved(Topic $topic){

        if(!$topic->slug){
            //$topic->slug = app(SlugTranslateHandler::class)->translate($topic->title);
            dispatch(new TranslateSlug($topic));
        }
    }

    //we need really carefully here.  We cannot use  "$topic->replies()->delete()" to delete all replies //because it trigger observer -> deleted again, and then again, which lead to dead loop
    //so here the only choise is operate database directly
    public function deleted(Topic $topic){
        //delete replies by class DB which operate database directly
        \DB::table('replies')->where('topic_id', $topic->id)->delete();
    }


}