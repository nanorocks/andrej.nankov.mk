<?php

namespace App\Helpers;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class Client
{
    /**
     * cache
     *
     * @param  mixed $key
     * @param  mixed $value
     * @return void
     */
    public static function cache(string $key, $value)
    {
        if (Cache::has($key)) {
            return Cache::get($key);
        }

        Cache::put($key, $value, 900);

        return $value;
    }
}
