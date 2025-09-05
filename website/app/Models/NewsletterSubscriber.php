<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NewsletterSubscriber extends Model
{
    // fillable props
    protected $fillable = [
        'email',
        'subscribed',
        'attributes'
    ];
}
