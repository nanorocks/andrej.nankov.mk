<?php

namespace App\Http\Controllers\AdminSide;

use Illuminate\Http\Request;
use App\Services\PostService;
use App\Http\Controllers\Controller;
use App\Http\Requests\Post\StoreRequest;
use App\Http\Requests\Post\UpdateRequest;
use App\Http\Resources\Post\ShowResource;
use App\Http\Resources\Post\IndexResource;
use App\Http\Resources\Post\StoreResource;
use App\Http\Resources\Post\UpdateResource;
use App\Http\Resources\Post\DestroyResource;

class PostController extends Controller
{
    public PostService $postService;

    /**
     * __construct
     *
     * @param  mixed $postService
     * @return void
     */
    public function __construct(PostService $postService)
    {
        $this->postService = $postService;
    }


    /**
     * @OA\Post(
     *     path="/admin/posts",
     *     tags={"AdminSide Post Model CRUD"},
     *     operationId="storePost",
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
     *                           "title": "Page1",
     *                           "subTitle": "Post sub title",
     *                           "text": "This is my post text",
     *                           "date": "2020-01-03",
     *                           "status": 1,
     *                           "references": "link1;link2",
     *                           "image": "",
     *                           "metaBudges": "rpm;py",
     *                           "category": "category2"
     *                  }
     *              )
     *          )
     *      ),
     *     @OA\Response(
     *      response=200,
     *      description="Store post.",
     *          @OA\JsonContent(type="object",
     *          @OA\Property(property="code", type="integer"),
     *          @OA\Property(property="message", type="string"),
     *          @OA\Property(property="data", type="array",
     *          @OA\Items(type="object",
     *                   @OA\Property(property="title", type="string"),
     *                   @OA\Property(property="unique_id", type="string"),
     *                   @OA\Property(property="subTitle", type="string"),
     *                   @OA\Property(property="text", type="string"),
     *                   @OA\Property(property="status", type="integer"),
     *                   @OA\Property(property="references", type="string"),
     *                   @OA\Property(property="image", type="string"),
     *                   @OA\Property(property="metaBudges", type="string"),
     *                   @OA\Property(property="userId", type="integer"),
     *                   @OA\Property(property="updated_at", type="string"),
     *                   @OA\Property(property="created_at", type="string"),
     *                   @OA\Property(property="date", type="string"),
     *                   @OA\Property(property="id", type="integer"),
     *                    ),
     *                ),
     *            ),
     *      ),
     *     @OA\Response(response=404, description="Not Found"),
     *     @OA\Response(response=500, description="Token has expired | Internal Server error")
     * )
     */
    public function store(StoreRequest $request)
    {
        return new StoreResource($this->postService->create($request->convertToDto()->toArray()));
    }

    /**
     * @OA\Put(
     *     path="/admin/posts/{id}",
     *     tags={"AdminSide Post Model CRUD"},
     *     operationId="updatePost",
     *     security={
     *          {"bearerAuth": {}}
     *      },
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *        @OA\Schema(
     *              type="integer"
     *        )
     *     ),
     *     @OA\RequestBody(
     *          @OA\MediaType(
     *              mediaType="application/json",
     *          @OA\Schema(
     *              @OA\Property(
     *                  property="name",
     *                  type="string"
     *                  ),
     *                  example={
     *                           "title": "Page1",
     *                           "subTitle": "Post sub title",
     *                           "text": "This is my post text",
     *                           "date": "2020-01-03",
     *                           "status": "1",
     *                           "references": "link1;link2",
     *                           "image": "",
     *                           "metaBudges": "rpm;py",
     *                           "category": "category2"
     *                  }
     *              )
     *          )
     *      ),
     *     @OA\Response(
     *      response=200,
     *      description="Update resource in Posts.",
     *          @OA\JsonContent(type="object",
     *          @OA\Property(property="code", type="integer"),
     *          @OA\Property(property="message", type="string"),
     *          @OA\Property(property="data", type="array",
     *          @OA\Items(type="object",
     *                   @OA\Property(property="title", type="string"),
     *                   @OA\Property(property="unique_id", type="string"),
     *                   @OA\Property(property="subTitle", type="string"),
     *                   @OA\Property(property="text", type="string"),
     *                   @OA\Property(property="status", type="integer"),
     *                   @OA\Property(property="references", type="string"),
     *                   @OA\Property(property="image", type="string"),
     *                   @OA\Property(property="metaBudges", type="string"),
     *                   @OA\Property(property="userId", type="integer"),
     *                   @OA\Property(property="updated_at", type="string"),
     *                   @OA\Property(property="created_at", type="string"),
     *                   @OA\Property(property="date", type="string"),
     *                   @OA\Property(property="id", type="integer"),
     *                    ),
     *                ),
     *            ),
     *      ),
     *     @OA\Response(response=404, description="Not Found"),
     *     @OA\Response(response=500, description="Token has expired | Internal Server error")
     * )
     */
    public function update(UpdateRequest $request, int $id)
    {
        return new UpdateResource($this->postService->update($request->convertToDto()->toArray(), $id));
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
        return new DestroyResource($this->postService->delete($id));
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
        return new IndexResource($this->postService->showWithPaginate($request->input('limit') ?? 4));
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
        return new ShowResource($this->postService->find($id));
    }
}
