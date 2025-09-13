<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
    protected $table = 'pages';

    protected $fillable = [
        'flag',
        'profile_image',
        'name',
        'title',
        'role',
        'headline',
        'intro',
        'content',
        'cv_url',
        'is_published',
        'include_seo_in_header',
        'seo_title',
        'seo_description',
        'seo_keywords',
        'seo_author',
        'seo_robots',
        'og_title',
        'og_description',
        'og_type',
        'og_url',
        'og_image',
        'og_image_alt',
        'og_site_name',
        'twitter_card',
        'twitter_title',
        'twitter_description',
        'twitter_image',
        'twitter_image_alt',
        'twitter_creator',
    ];


    public static function getAboutPage()
    {
        return self::where('flag', 'about')->where('is_published', true)->first();
    }

    public static function getHomepage()
    {
        return cache()->remember('homepage_page', 120, function () {
            return self::where('flag', 'homepage')->where('is_published', true)->first();
        });
    }

    public static function getNewsletterPage()
    {
        return self::where('flag', 'newsletter')->where('is_published', true)->first();
    }
}
