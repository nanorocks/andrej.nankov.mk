<?php

namespace App\Http\Controllers\ClientSide;

use App\Models\User;
use App\Http\Controllers\Controller;
use App\Http\Resources\User\IndexResource;

class PageController extends Controller
{
    /**
     * @OA\Get(
     *     path="/cv",
     *     operationId="pageUser",
     *     @OA\Parameter(
     *       name="key",
     *       required=false,
     *       in="query",
     *       description="HMAC_SHARED_API_KEY",
     *       @OA\Schema(
     *         type="string"
     *       )
     *     ),
     *     @OA\Parameter(
     *       name="data",
     *       required=false,
     *       in="query",
     *       description="BASE_64_ENCODE_DATA",
     *       @OA\Schema(
     *         type="string"
     *       )
     *     ),
     *     @OA\Parameter(
     *       name="signature",
     *       required=false,
     *       in="query",
     *       description="BASE_64_ENCODE_SIGNATURE",
     *       @OA\Schema(
     *         type="string"
     *       )
     *     ),
     *     tags={"ClientSide"},
     *     @OA\Response(response="200", description="Get information from my personal cv")
     * )
     */
    public function index()
    {
        return new IndexResource(User::where(User::EMAIL, env('DEFAULT_USER_EMAIL'))->get());
    }
}
