<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class Config extends Model{

    public const TABLE = 'configs';


    public const PAGE_TITLE = 'pageTitle';

    public const PAGE_DESCRIPTION = 'pageDescription';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        self::PAGE_TITLE,
        self::PAGE_DESCRIPTION,
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

}
