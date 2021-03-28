<?php

namespace App\Http\Controllers\ClientSide;

use App\Models\Project;
use Illuminate\Http\Request;
use App\Services\ProjectService;
use App\Http\Controllers\Controller;
use App\Http\Resources\Project\ShowResource;
use App\Http\Resources\Project\IndexResource;

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
     * @OA\Get(
     *     path="/projects",
     *     operationId="projectsUser",
     *     @OA\Parameter(
     *       name="limit",
     *       required=false,
     *       in="query",
     *       description="limit data",
     *       @OA\Schema(
     *         type="string"
     *       )
     *     ),
     *     @OA\Parameter(
     *       name="page",
     *       required=false,
     *       in="query",
     *       description="page number",
     *       @OA\Schema(
     *         type="string"
     *       )
     *     ),
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
     *     @OA\Response(response="200", description="Get information for projects")
     * )
     */
    public function index(Request $request)
    {
        return new IndexResource($this->projectService->paginateWithOrder($request->input('limit') ?? 4, Project::DATE, 'desc'));
    }

    /**
     * @OA\Get(
     *     path="/projects/{id}",
     *     operationId="singleProjectUser",
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
     *     @OA\Response(response="200", description="Get information for single project")
     * )
     */
    public function show(int $id)
    {
        return new ShowResource($this->projectService->find($id));
    }
}
