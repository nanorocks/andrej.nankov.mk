<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LsArticle extends Model
{
    use HasFactory;

    protected $table = 'ls_articles';

    public function categories()
    {
        return $this->belongsToMany(LsCategory::class);
    }
}
