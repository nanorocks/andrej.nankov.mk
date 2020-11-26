<?php

namespace App\Http\Controllers;

use App\Models\Config;
use App\Models\Post;

class ConfigController extends Controller
{

    /**
     * getConfigInfo
     *
     * @return void
     */
    public function getConfig()
    {
        return Config::all(Config::PAGE_TITLE, Config::PAGE_DESCRIPTION);
    }
}
