<?php

namespace App\Http\Controllers\AdminSide;

use App\Models\Post;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\Post\ShowResource;
use App\Http\Resources\Post\IndexResource;
use App\Http\Resources\Post\DestroyResource;

class PostController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

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
     * @OA\Delete(
     *     path="/admin/posts/{id}",
     *     tags={"AdminSide Post Model CRUD"},
     *     operationId="destroyPost",
     *     security={
     *          {"bearerAuth": {}}
     *      },
     *     @OA\Parameter(
     *         description="ID of Post",
     *         in="path",
     *         name="id",
     *         required=true,
     *         @OA\Schema(
     *           type="integer",
     *           format="int64"
     *         )
     *     ),
     *     @OA\Response(
     *      response=200,
     *      description="Deleted Post",
     *          @OA\JsonContent(type="object",
     *          @OA\Property(property="code", type="integer"),
     *          @OA\Property(property="message", type="string"),
     *          @OA\Property(property="data", type="integer")),
     *      ),
     *     @OA\Response(response=404, description="Not Found"),
     *     @OA\Response(response=500, description="Token has expired | Internal Server error")
     * )
     */
    public function destroy(int $id)
    {
        return new DestroyResource(Post::destroy($id));
    }

    /**
     * @OA\Get(
     *     path="/admin/posts",
     *     tags={"AdminSide Post Model CRUD"},
     *     operationId="chunkPost",
     *     security={
     *          {"bearerAuth": {}}
     *      },
     *     @OA\Parameter(
     *       name="limit",
     *       required=false,
     *       in="query",
     *       description="limit data",
     *       @OA\Schema(
     *         type="integer"
     *       )
     *     ),
     *     @OA\Parameter(
     *       name="page",
     *       required=false,
     *       in="query",
     *       description="page number",
     *       @OA\Schema(
     *         type="integer"
     *       )
     *     ),
     *     @OA\Response(
     *      response=200,
     *      description="Get list of posts.",
     *          @OA\JsonContent(type="object",
     *          @OA\Property(property="code", type="integer"),
     *          @OA\Property(property="message", type="string"),
     *          @OA\Property(property="data", type="array",
     *          @OA\Items(type="object",
     *              @OA\Property(property="id", type="integer"),
     *              @OA\Property(property="unique_id", type="string"),
     *              @OA\Property(property="title", type="string"),
     *              @OA\Property(property="subTitle", type="string"),
     *              @OA\Property(property="text", type="string"),
     *              @OA\Property(property="date", type="string"),
     *              @OA\Property(property="status", type="integer"),
     *              @OA\Property(property="references", type="string"),
     *              @OA\Property(property="image", type="string"),
     *              @OA\Property(property="metaBudges", type="string"),
     *              @OA\Property(property="user_id", type="integer"),
     *              @OA\Property(property="created_at", type="string"),
     *              @OA\Property(property="updated_at", type="string")
     *                    ),
     *                ),
     *            ),
     *      ),
     *     @OA\Response(response=404, description="Not Found"),
     *     @OA\Response(response=500, description="Token has expired | Internal Server error")
     * )
     */
    public function index(Request $request)
    {
        $limit = $request->input('limit') ?? 4;
        return new IndexResource(Post::orderBy(Post::DATE, 'desc')->paginate($limit));
    }

    /**
     * @OA\Get(
     *     path="/admin/posts/{id}",
     *     tags={"AdminSide Post Model CRUD"},
     *     operationId="showPost",
     *     security={
     *          {"bearerAuth": {}}
     *     },
     *     @OA\Parameter(
     *         description="ID of Post",
     *         in="path",
     *         name="id",
     *         required=true,
     *         @OA\Schema(
     *           type="integer",
     *           format="int64"
     *         )
     *     ),
     *     @OA\Response(
     *      response=200,
     *      description="Single Post.",
     *          @OA\JsonContent(type="object",
     *          @OA\Property(property="code", type="integer"),
     *          @OA\Property(property="message", type="string"),
     *          @OA\Property(property="data", type="array",
     *          @OA\Items(type="object",
     *              @OA\Property(property="id", type="integer"),
     *              @OA\Property(property="unique_id", type="string"),
     *              @OA\Property(property="title", type="string"),
     *              @OA\Property(property="subTitle", type="string"),
     *              @OA\Property(property="text", type="string"),
     *              @OA\Property(property="date", type="string"),
     *              @OA\Property(property="status", type="integer"),
     *              @OA\Property(property="references", type="string"),
     *              @OA\Property(property="image", type="string"),
     *              @OA\Property(property="metaBudges", type="string"),
     *              @OA\Property(property="user_id", type="integer"),
     *              @OA\Property(property="created_at", type="string"),
     *              @OA\Property(property="updated_at", type="string")
     *                  ),
     *                ),
     *            ),
     *      ),
     *     @OA\Response(response=404, description="Not Found"),
     *     @OA\Response(response=500, description="Token has expired | Internal Server error")
     * )
     */
    public function show(int $id)
    {
        return new ShowResource(Post::find($id));
    }
}
