<?php

namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Model;

/**
 * Class User
 *
 * @property $id
 * @property $name
 * @property $avatar
 * @property $email
 * @property $email_verified_at
 * @property $password
 * @property $remember_token
 * @property $phone_number
 * @property $address
 * @property $website_url
 * @property $medium_url
 * @property $social_media
 * @property $role
 * @property $bio
 * @property $created_at
 * @property $updated_at
 *
 * @property Project[] $projects
 * @property Story[] $stories
 * @property Video[] $videos
 * @package App
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class User extends Model
{
    use Authenticatable, MustVerifyEmail;

    protected $perPage = 20;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = ['name', 'avatar', 'email', 'phone_number', 'address', 'website_url', 'medium_url', 'social_media', 'role', 'bio'];


    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function projects()
    {
        return $this->hasMany(\App\Models\Project::class, 'id', 'user_id');
    }
    
    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function stories()
    {
        return $this->hasMany(\App\Models\Story::class, 'id', 'author_id');
    }
    
    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function videos()
    {
        return $this->hasMany(\App\Models\Video::class, 'id', 'author_id');
    }
    
}
