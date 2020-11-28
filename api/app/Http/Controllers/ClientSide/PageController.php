<?php

namespace App\Http\Controllers\ClientSide;

use App\Models\User;
use App\Http\Controllers\Controller;

class PageController extends Controller
{
    /**
     * @OA\Get(
     *     path="/",
     *     description="Get CV",
     *     @OA\Response(response="default", description="Welcome page")
     * )
     */
    public function getCv()
    {
        return User::where(User::EMAIL, env('DEFAULT_USER_EMAIL'))->get();
    }
}
