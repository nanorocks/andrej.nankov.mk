<?php

namespace App\Http\Controllers\AdminSide;

use Illuminate\Http\Request;
use App\Services\ProjectService;
use App\Http\Controllers\Controller;
use App\Http\Requests\Project\StoreRequest;
use App\Http\Requests\Project\UpdateRequest;
use App\Http\Resources\Project\ShowResource;
use App\Http\Resources\Project\IndexResource;
use App\Http\Resources\Project\StoreResource;
use App\Http\Resources\Project\UpdateResource;
use App\Http\Resources\Project\DestroyResource;

class ProjectController extends Controller
{
    public ProjectService $projectService;

    /**
     * __construct
     *
     * @param  mixed $projectService
     * @return void
     */
    public function __construct(ProjectService $projectService)
    {
        $this->projectService = $projectService;
    }

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
        return new StoreResource($this->projectService->create($request->convertToDto()->toArray()));
    }

    /**
     * @OA\Put(
     *     path="/admin/projects/{id}",
     *     tags={"AdminSide Project Model CRUD"},
     *     operationId="updateProject",
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
     *                           "description": "Project sub title",
     *                           "date": "2020-01-03",
     *                           "status": "1",
     *                           "link": "http://www.google.com",
     *                           "image": "",
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
     *                   @OA\Property(property="status", type="string"),
     *                   @OA\Property(property="link", type="string"),
     *                   @OA\Property(property="image", type="string"),
     *                   @OA\Property(property="userId", type="integer"),
     *                   @OA\Property(property="updated_at", type="string"),
     *                   @OA\Property(property="created_at", type="string"),
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
        return new UpdateResource($this->projectService->update($request->convertToDto()->toArray(), $id));
    }

    /**
     * @OA\Delete(
     *     path="/admin/project/{id}",
     *     tags={"AdminSide Project Model CRUD"},
     *     operationId="destroyProject",
     *     security={
     *          {"bearerAuth": {}}
     *      },
     *     @OA\Parameter(
     *         description="ID of Project",
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
     *      description="Deleted Project",
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
        return new DestroyResource($this->projectService->delete($id));
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
        return new IndexResource($this->projectService->showWithPaginate($request->input('limit') ?? 4));
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
        return new ShowResource($this->projectService->find($id));
    }
}
