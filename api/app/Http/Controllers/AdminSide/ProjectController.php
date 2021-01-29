<?php

namespace App\Http\Controllers\AdminSide;

use App\Models\Project;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Project\StoreRequest;
use App\Http\Resources\Project\ShowResource;
use App\Http\Resources\Project\IndexResource;
use App\Http\Resources\Project\StoreResource;
use App\Http\Resources\Project\DestroyResource;

class ProjectController extends Controller
{

    /**
     * @OA\Post(
     *     path="/admin/projects",
     *     tags={"AdminSide Project Model CRUD"},
     *     operationId="storeProject",
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
     *                           "description": "Project sub title",
     *                           "date": "2020-01-03",
     *                           "status": "1",
     *                           "link": "",
     *                           "image": "",
     *                  }
     *              )
     *          )
     *      ),
     *     @OA\Response(
     *      response=200,
     *      description="Store project.",
     *          @OA\JsonContent(type="object",
     *          @OA\Property(property="code", type="integer"),
     *          @OA\Property(property="message", type="string"),
     *          @OA\Property(property="data", type="array",
     *          @OA\Items(type="object",
     *                   @OA\Property(property="title", type="string"),
     *                   @OA\Property(property="description", type="string"),
     *                   @OA\Property(property="date", type="string"),
     *                   @OA\Property(property="status", type="string"),
     *                   @OA\Property(property="link", type="string"),
     *                   @OA\Property(property="image", type="string"),
     *                   @OA\Property(property="userId", type="integer"),
     *                   @OA\Property(property="updated_at", type="string"),
     *                   @OA\Property(property="created_at", type="string"),
     *                   @OA\Property(property="id", type="integer"),
     *
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
        return new StoreResource(Project::create($request->convertToDto()->toArray()));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, int $id)
    {
        //
    }

    /**
     * @OA\Delete(
     *     path="/admin/projects/{id}",
     *     tags={"AdminSide Project Model CRUD"},
     *     operationId="destroyProject",
     *     security={
     *          {"bearerAuth": {}}
     *      },
     *     @OA\Parameter(
     *         description="ID of project",
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
     *      description="Deleted project",
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
        return new DestroyResource(Project::destroy($id));
    }

    /**
     * @OA\Get(
     *     path="/admin/projects",
     *     tags={"AdminSide Project Model CRUD"},
     *     operationId="chunkProject",
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
     *      description="Get list of projects.",
     *          @OA\JsonContent(type="object",
     *          @OA\Property(property="code", type="integer"),
     *          @OA\Property(property="message", type="string"),
     *          @OA\Property(property="data", type="array",
     *          @OA\Items(type="object",
     *              @OA\Property(property="id", type="integer"),
     *              @OA\Property(property="title", type="string"),
     *              @OA\Property(property="description", type="string"),
     *              @OA\Property(property="date", type="string"),
     *              @OA\Property(property="link", type="string"),
     *              @OA\Property(property="image", type="string"),
     *              @OA\Property(property="user_id", type="integer"),
     *              @OA\Property(property="created_at", type="string"),
     *              @OA\Property(property="updated_at", type="string"),
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
        return new IndexResource(Project::orderBy(Project::DATE, 'desc')->paginate($limit));
    }

    /**
     * @OA\Get(
     *     path="/admin/projects/{id}",
     *     tags={"AdminSide Project Model CRUD"},
     *     operationId="showProject",
     *     security={
     *          {"bearerAuth": {}}
     *     },
     *     @OA\Parameter(
     *         description="ID of project",
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
     *      description="Single project.",
     *          @OA\JsonContent(type="object",
     *          @OA\Property(property="code", type="integer"),
     *          @OA\Property(property="message", type="string"),
     *          @OA\Property(property="data", type="array",
     *          @OA\Items(type="object",
     *              @OA\Property(property="id", type="integer"),
     *              @OA\Property(property="title", type="string"),
     *              @OA\Property(property="description", type="string"),
     *              @OA\Property(property="date", type="string"),
     *              @OA\Property(property="link", type="string"),
     *              @OA\Property(property="image", type="string"),
     *              @OA\Property(property="user_id", type="integer"),
     *              @OA\Property(property="created_at", type="string"),
     *              @OA\Property(property="updated_at", type="string"),
     *                    ),
     *                ),
     *            ),
     *      ),
     *     @OA\Response(response=404, description="Not Found"),
     *     @OA\Response(response=500, description="Token has expired | Internal Server error")
     * )
     */
    public function show(int $id)
    {
        return new ShowResource(Project::find($id));
    }
}
