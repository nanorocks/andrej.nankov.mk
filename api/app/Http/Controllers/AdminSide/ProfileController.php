<?php

namespace App\Http\Controllers\AdminSide;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Profile\UpdateRequest;
use App\Http\Resources\Profile\ShowResource;
use App\Http\Resources\Profile\UpdateResource;

class ProfileController extends Controller
{

    /**
     * @OA\Post(
     *     path="/admin/profile",
     *     tags={"AdminSide Profile Model CRUD"},
     *     operationId="updateProfile",
     *     security={
     *          {"bearerAuth": {}}
     *      },
     *     @OA\RequestBody(
     *          @OA\MediaType(
     *              mediaType="application/json",
     *          @OA\Schema(
     *              @OA\Property(
     *                  property="name",
     *                  type="string"
     *                  ),
     *                  example={
     *                           "email": "andrejnankov@gmail.com",
     *                           "name": "andrejnankov",
     *                           "intro": "andrejnankov intro",
     *                           "summary": "andrejnankov summary",
     *                           "currentWork": "andrejnankov current work",
     *                           "topProgrammingLanguages": "PHP;JS",
     *                           "goals": "Generalist with focus on concepts.;Believer that success in career depends on persistence and willingness to learn.;Understanding client requirements and communicating the progress of the project are core values in achieving the project goals.",
     *                           "quotes": {"q1":"aaaa"},
     *                           "socMedia": {"fb":"fb.com"},
     *                           "highlights": {"1995":{"By a new car","Get a new computer"}},
     *                           "address": "Skopje, Macedonia",
     *                           "phone": "(+389)712-16813",
     *                  }
     *              )
     *          )
     *      ),
     *     @OA\Response(
     *      response=200,
     *      description="Update resource in project.",
     *          @OA\JsonContent(type="object",
     *          @OA\Property(property="code", type="integer"),
     *          @OA\Property(property="message", type="string"),
     *          @OA\Property(property="data", type="array",
     *          @OA\Items(type="object",
     *                   @OA\Property(property="title", type="string"),
     *                   @OA\Property(property="description", type="string"),
     *                   @OA\Property(property="date", type="string"),
     *                    ),
     *                ),
     *            ),
     *      ),
     *     @OA\Response(response=404, description="Not Found"),
     *     @OA\Response(response=500, description="Token has expired | Internal Server error")
     * )
     */
    public function update(UpdateRequest $request)
    {
        $id = $request->convertToDto()->toArray()['id'];
        User::whereId($id)->update($request->convertToDto()->toArray());
        return new UpdateResource(User::whereId($id)->first());
    }


    /**
     * @OA\Get(
     *     path="/admin/profile",
     *     tags={"AdminSide Profile Model CRUD"},
     *     operationId="chunkProfile",
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
