<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SocialLink extends Model
{
    protected $fillable = ['name', 'url', 'icon', 'active'];


    public static function getActiveSocialLinks()
    {
        return \Illuminate\Support\Facades\Cache::remember(
            'active_social_links',
            now()->addMinutes(10),
            function () {
                return self::where('active', true)->get();
            }
        );
    }
}
