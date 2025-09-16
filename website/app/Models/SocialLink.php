<?php

namespace App\Models;

use Spatie\Activitylog\LogOptions;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class SocialLink extends Model
{
    protected $fillable = ['name', 'url', 'icon', 'active'];

    use LogsActivity;

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['name', 'url', 'icon', 'active']);
    }

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
