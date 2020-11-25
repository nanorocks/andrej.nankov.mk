<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Project extends Model{

    public const TABLE = 'projects';


    public const TITLE = 'title';

    public const DESCRIPTION = 'description';

    public const DATE = 'date';

    public const STATUS = 'status';

    public const LINK = 'link';

    public const IMAGE = 'image';

    public const USER_ID = 'userId';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        self::TITLE,
        self::DESCRIPTION,
        self::DATE,
        self::STATUS,
        self::LINK,
        self::IMAGE,
        self::USER_ID
    ];
}
