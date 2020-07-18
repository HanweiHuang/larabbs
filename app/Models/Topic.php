<?php

namespace App\Models;

class Topic extends Model
{
    protected $fillable = [
        'title',
        'body',
        'user_id',
        'category_id',
        'excerpt',
        'slug'];

    /**
     * Audit events settings
     */
    protected static $recordEvents = ['created'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function replies()
    {
        return $this->hasMany(Reply::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * scope
     *
     * @param $query
     * @param $order
     * @return mixed
     */
    public function scopeWithOrder($query,$order)
    {
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

    /**
     * @param $query
     * @return mixed
     */
    public function scopeRecentReplied($query)
    {
        return $query->orderBy('updated_at', 'desc');
    }

    /**
     * @param $query
     * @return mixed
     */
    public function scopeRecent($query)
    {
        return $query->orderBy('created_at', 'desc');
    }

    /**
     * create url with topic_id/topic_slug/and_other_params
     *
     * @param array $params
     * @return string
     */
    public function link($params = [])
    {
        return route('topics.show', array_merge([$this->id, $this->slug], $params));
    }
}