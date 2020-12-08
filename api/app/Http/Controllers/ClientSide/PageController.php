<?php

namespace App\Http\Controllers\ClientSide;

use App\Models\User;
use App\Http\Controllers\Controller;

class PageController extends Controller
{
    /**
     * @OA\Get(
     *     path="/cv",
     *     description="Get CV",
     *     @OA\Contact(
     *          email="andrejnankov@gmail.com",
     *          name="Andrej Nankov"
     *     ),
     *     @OA\Response(response="200", description="Get information from my personal cv")
     * )
     */
    public function index()
    {
        return User::where(User::EMAIL, env('DEFAULT_USER_EMAIL'))->get();
    }
}
