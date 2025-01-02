<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Tool
 *
 * @property $id
 * @property $uuid
 * @property $title
 * @property $slug
 * @property $description
 * @property $photo_url
 * @property $caption
 * @property $website_url
 * @property $created_at
 * @property $updated_at
 *
 * @package App
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class Tool extends Model
{
    
    protected $perPage = 20;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = ['title', 'slug', 'description', 'photo_url', 'caption', 'website_url'];


}
