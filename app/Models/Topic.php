<?php

namespace App\Models;

class Topic extends Model
{
    protected $fillable = [
        'title',
        'body',
        'category_id',
        'excerpt',
        'slug'];

    //one topic has many replys
    public function replies(){
        return $this->hasMany(Reply::class);
    }

    //data relation
    public function category(){
        return $this->belongsTo(Category::class);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function scopeWithOrder($query,$order){
        switch($order){
            case 'recent':
                $query->recent();
                break;
            default:
                $query->recentReplied();
                break;
        }

        return $query->with('user','category');
    }

    public function scopeRecentReplied($query){
        // 当话题有新回复时，我们将编写逻辑来更新话题模型的 reply_count 属性，
        // 此时会自动触发框架对数据模型 updated_at 时间戳的更新
        return $query->orderBy('updated_at', 'desc');
    }

    public function scopeRecent($query)
    {
        // 按照创建时间排序
        return $query->orderBy('created_at', 'desc');
    }

    //create url with topic_id/topic_slug/and_other_params
    public function link($params = []){
        return route('topics.show', array_merge([$this->id, $this->slug], $params));
    }
}