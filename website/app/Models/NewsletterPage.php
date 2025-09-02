<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NewsletterPage extends Model
{
    protected $fillable = [
        'profile_image',
        'name',
        'role',
        'headline',
        'intro',
        'main_content'
    ];
}
