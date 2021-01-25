<?php

namespace App\Http\Controllers\AdminSide;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\Profile\ShowResource;

class ProfileController extends Controller
{

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }


    /**
     * @OA\Get(
     *     path="/admin/profile",
     *     tags={"AdminSide User Model CRUD"},
     *     operationId="chunkUser",
     *     security={
     *          {"bearerAuth": {}}
     *      },
     *     @OA\Response(
     *      response=200,
     *      description="Get profile.",
     *          @OA\JsonContent(type="object",
     *          @OA\Property(property="code", type="integer"),
     *          @OA\Property(property="message", type="string"),
     *          @OA\Property(property="data", type="object",
     *              @OA\Property(property="id", type="integer"),
     *              @OA\Property(property="email", type="string"),
     *              @OA\Property(property="name", type="string"),
     *              @OA\Property(property="intro", type="string"),
     *              @OA\Property(property="summary", type="string"),
     *              @OA\Property(property="currentWork", type="string"),
     *              @OA\Property(property="topProgrammingLanguages", type="string"),
     *              @OA\Property(property="goals", type="string"),
     *              @OA\Property(property="quotes", type="string"),
     *              @OA\Property(property="socMedia", type="string"),
     *              @OA\Property(property="highlights", type="string"),
     *              @OA\Property(property="address", type="string"),
     *              @OA\Property(property="phone", type="string"),
     *              @OA\Property(property="created_at", type="string"),
     *              @OA\Property(property="updated_at", type="string"),
     *                ),
     *            ),
     *      ),
     *     @OA\Response(response=404, description="Not Found"),
     *     @OA\Response(response=500, description="Token has expired | Internal Server error")
     * )
     */
    public function show()
    {
        return new ShowResource(User::where(User::EMAIL, env('DEFAULT_USER_EMAIL'))->get());
    }

}
