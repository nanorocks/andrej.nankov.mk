<?php

namespace App\Models;

use App\Models\Post;
use App\Models\Config;
use App\Models\Project;
use Illuminate\Auth\Authenticatable;
use Laravel\Lumen\Auth\Authorizable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;

class User extends Model implements AuthenticatableContract, AuthorizableContract
{
    use Authenticatable, Authorizable, HasFactory;

    public const TABLE = 'users';

    public const ID = 'id';

    public const EMAIL = 'email';

    public const PHOTO = 'photo';

    public const NAME = 'name';

    public const INTRO = 'intro';

    public const SUMMARY = 'summary';

    public const CURRENT_WORK = 'currentWork';

    public const TOP_PROGRAMMING_LANGUAGES = 'topProgrammingLanguages';

    public const GOALS = 'goals';

    public const QUOTES = 'quotes';

    public const SOC_MEDIA = 'socMedia';

    public const PASSWORD = 'password';

    public const HIGHLIGHTS = 'highlights';

    public const ADDRESS = 'address';

    public const PHONE = 'phone';



    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        self::PHOTO,
        self::EMAIL,
        self::NAME,
        self::INTRO,
        self::SUMMARY,
        self::CURRENT_WORK,
        self::TOP_PROGRAMMING_LANGUAGES,
        self::GOALS,
        self::QUOTES,
        self::SOC_MEDIA,
        self::HIGHLIGHTS,
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
        self::PASSWORD
    ];

    public function post()
    {
        return $this->hasOne(Post::class);
    }

    public function projects()
    {
        return $this->hasMany(Project::class);
    }

    public function configs()
    {
        return $this->hasMany(Config::class);
    }

}
