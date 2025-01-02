<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Video
 *
 * @property $id
 * @property $uuid
 * @property $title
 * @property $slug
 * @property $description
 * @property $video_url
 * @property $thumbnail_url
 * @property $author_id
 * @property $tags
 * @property $views_count
 * @property $likes_count
 * @property $comments_count
 * @property $is_published
 * @property $published_at
 * @property $created_at
 * @property $updated_at
 *
 * @property User $user
 * @package App
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class Video extends Model
{
    
    protected $perPage = 20;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = ['title', 'slug', 'description', 'video_url', 'thumbnail_url', 'author_id', 'tags', 'views_count', 'likes_count', 'comments_count', 'is_published', 'published_at'];


    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(\App\Models\User::class, 'author_id', 'id');
    }
    
}
