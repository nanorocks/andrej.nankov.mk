<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AboutPage extends Model
{
    protected $fillable = [
        'profile_image',
        'name',
        'title',
        'about_content',
        'cv_url'
    ];
}
