<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Story
 *
 * @property $id
 * @property $uuid
 * @property $slug
 * @property $title
 * @property $content
 * @property $excerpt
 * @property $author_id
 * @property $tags
 * @property $category_id
 * @property $published_at
 * @property $is_published
 * @property $is_draft
 * @property $views_count
 * @property $likes_count
 * @property $comments_count
 * @property $featured_image
 * @property $media
 * @property $seo_page_id
 * @property $created_at
 * @property $updated_at
 *
 * @property User $user
 * @property Category $category
 * @property SeoPage $seoPage
 * @package App
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class Story extends Model
{

    protected $perPage = 20;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = ['uuid', 'slug', 'title', 'content', 'excerpt', 'author_id', 'tags', 'category_id', 'published_at', 'is_published', 'is_draft', 'views_count', 'likes_count', 'comments_count', 'featured_image', 'media', 'seo_page_id'];


    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(\App\Models\User::class, 'author_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function category()
    {
        return $this->belongsTo(\App\Models\Category::class, 'category_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function seoPage()
    {
        return $this->belongsTo(\App\Models\SeoPage::class, 'seo_page_id', 'id');
    }
}
