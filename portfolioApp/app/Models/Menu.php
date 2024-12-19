<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Menu
 *
 * @property $id
 * @property $title
 * @property $slug
 * @property $url
 * @property $parent_id
 * @property $order
 * @property $created_at
 * @property $updated_at
 *
 * @property Menu $menu
 * @property Menu[] $menuses
 * @package App
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class Menu extends Model
{
    
    protected $perPage = 20;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = ['title', 'slug', 'url', 'parent_id', 'order'];


    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function menu()
    {
        return $this->belongsTo(\App\Models\Menu::class, 'parent_id', 'id');
    }
    
    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function menuses()
    {
        return $this->hasMany(\App\Models\Menu::class, 'id', 'parent_id');
    }
    
}
