<?php

namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Lumen\Auth\Authorizable;

class User extends Model implements AuthenticatableContract, AuthorizableContract
{
    use Authenticatable, Authorizable, HasFactory;

    public const TABLE = 'users';

    public const ID = 'id';


    public const EMAIL = 'email';

    public const NAME = 'name';

    public const INTRO = 'intro';

    public const SUMMARY = 'summary';

    public const CURRENT_WORK = 'currentWork';

    public const TOP_PROGRAMMING_LANGUAGES = 'topProgrammingLanguages';

    public const GOALS = 'goals';

    public const QUOTES = 'quotes';

    public const SOC_MEDIA = 'socMedia';

    public const PASSWORD = 'password';


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        self::EMAIL,
        self::NAME,
        self::INTRO,
        self::SUMMARY,
        self::CURRENT_WORK,
        self::TOP_PROGRAMMING_LANGUAGES,
        self::GOALS,
        self::QUOTES,
        self::SOC_MEDIA,
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
        self::PASSWORD
    ];
}
