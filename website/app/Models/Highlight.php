<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Highlight
 *
 * @property $id
 * @property $year
 * @property $event
 * @property $created_at
 * @property $updated_at
 *
 * @package App
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class Highlight extends Model
{
    
    protected $perPage = 20;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = ['year', 'event'];


}
