<?php

namespace App\Http\Controllers\ClientSide;

use App\Models\Post;
use App\Models\Config;
use App\Http\Controllers\Controller;
use App\Http\Resources\Config\IndexResource;

class ConfigController extends Controller
{

    /**
     * getConfigInfo
     *
     * @return void
     */
    public function index()
    {
        return new IndexResource(Config::all(Config::PAGE_TITLE, Config::PAGE_DESCRIPTION));
    }
}
