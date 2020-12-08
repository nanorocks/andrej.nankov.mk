<?php

namespace App\Http\Controllers\ClientSide;

use App\Models\Post;
use App\Models\Config;
use App\Http\Controllers\Controller;

class ConfigController extends Controller
{

    /**
     * getConfigInfo
     *
     * @return void
     */
    public function index()
    {
        return Config::all(Config::PAGE_TITLE, Config::PAGE_DESCRIPTION);
    }
}
