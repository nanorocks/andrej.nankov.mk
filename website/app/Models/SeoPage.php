<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class SeoPage
 *
 * @property $id
 * @property $uuid
 * @property $slug
 * @property $keywords
 * @property $title
 * @property $description
 * @property $meta_robots
 * @property $canonical_url
 * @property $og_title
 * @property $og_description
 * @property $og_image
 * @property $structured_data
 * @property $locale
 * @property $sitemap_priority
 * @property $sitemap_frequency
 * @property $last_seo_audit
 * @property $custom_scripts
 * @property $created_at
 * @property $updated_at
 *
 * @property Story[] $stories
 * @package App
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class SeoPage extends Model
{
    
    protected $perPage = 20;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = ['slug', 'keywords', 'title', 'description', 'meta_robots', 'canonical_url', 'og_title', 'og_description', 'og_image', 'structured_data', 'locale', 'sitemap_priority', 'sitemap_frequency', 'last_seo_audit', 'custom_scripts'];


    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function stories()
    {
        return $this->hasMany(\App\Models\Story::class, 'id', 'seo_page_id');
    }
    
}
