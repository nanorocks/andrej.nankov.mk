<?php

namespace App\Http\Controllers;

use App\Models\User;

class PageController extends Controller
{
    /**
     * getCv
     *
     * @return void
     */
    public function getCv()
    {
        return User::where(User::EMAIL, env('DEFAULT_USER_EMAIL'))->get();
    }
}
