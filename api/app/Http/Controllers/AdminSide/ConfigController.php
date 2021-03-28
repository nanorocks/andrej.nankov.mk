<?php

namespace App\Http\Controllers\AdminSide;

use Illuminate\Http\Request;
use App\Services\ConfigService;
use App\Http\Controllers\Controller;
use App\Http\Requests\Config\StoreRequest;
use App\Http\Requests\Config\UpdateRequest;
use App\Http\Resources\Config\ShowResource;
use App\Http\Resources\Config\IndexResource;
use App\Http\Resources\Config\StoreResource;
use App\Http\Resources\Config\UpdateResource;
use App\Http\Resources\Config\DestroyResource;

class ConfigController extends Controller
{

    public ConfigService $configService;

    /**
     * __construct
     *
     * @param  mixed $configService
     * @return void
     */
    public function __construct(ConfigService $configService)
    {
        $this->configService = $configService;
    }

    /**
     * @OA\Post(
     *     path="/admin/configs",
     *     tags={"AdminSide Config Model CRUD"},
     *     operationId="storeConfig",
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
     *                  example={"pageTitle": "Page1", "pageDescription": "page1-description"}
     *              )
     *          )
     *      ),
     *     @OA\Response(
     *      response=200,
     *      description="Store config.",
     *          @OA\JsonContent(type="object",
     *          @OA\Property(property="code", type="integer"),
     *          @OA\Property(property="message", type="string"),
     *          @OA\Property(property="data", type="array",
     *          @OA\Items(type="object",
     *              @OA\Property(property="pageTitle", type="string"),
     *              @OA\Property(property="pageDescription", type="string"),
     *              @OA\Property(property="updated_at", type="string"),
     *              @OA\Property(property="created_at", type="string"),
     *              @OA\Property(property="id", type="integer"),
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
        return new StoreResource($this->configService->create($request->convertToDto()->toArray()));
    }

    /**
     * @OA\Put(
     *     path="/admin/configs/{id}",
     *     tags={"AdminSide Config Model CRUD"},
     *     operationId="updateConfig",
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
     *                  example={"pageTitle": "Page1", "pageDescription": "page1-description"}
     *              )
     *          )
     *      ),
     *     @OA\Response(
     *      response=200,
     *      description="Update resource in configs.",
     *          @OA\JsonContent(type="object",
     *          @OA\Property(property="code", type="integer"),
     *          @OA\Property(property="message", type="string"),
     *          @OA\Property(property="data", type="array",
     *          @OA\Items(type="object",
     *              @OA\Property(property="pageTitle", type="string"),
     *              @OA\Property(property="pageDescription", type="string"),
     *              @OA\Property(property="updated_at", type="string"),
     *              @OA\Property(property="created_at", type="string"),
     *              @OA\Property(property="id", type="integer"),
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
        return new UpdateResource($this->configService->update($request->convertToDto()->toArray(), $id));
    }

    /**
     * @OA\Delete(
     *     path="/admin/configs/{id}",
     *     tags={"AdminSide Config Model CRUD"},
     *     operationId="destroyConfig",
     *     security={
     *          {"bearerAuth": {}}
     *      },
     *     @OA\Parameter(
     *         description="ID of Config",
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
     *      description="Deleted Config",
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
        return new DestroyResource($this->configService->delete($id));
    }

    /**
     * @OA\Get(
     *     path="/admin/configs",
     *     tags={"AdminSide Config Model CRUD"},
     *     operationId="chunkConfig",
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
     *      description="Get list of configs.",
     *          @OA\JsonContent(type="object",
     *          @OA\Property(property="code", type="integer"),
     *          @OA\Property(property="message", type="string"),
     *          @OA\Property(property="data", type="array",
     *          @OA\Items(type="object",
     *              @OA\Property(property="pageTitle", type="string"),
     *              @OA\Property(property="pageDescription", type="string"),
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
        return new IndexResource($this->configService->showWithPaginate($request->input('limit') ?? 4));
    }

    /**
     * @OA\Get(
     *     path="/admin/configs/{id}",
     *     tags={"AdminSide Config Model CRUD"},
     *     operationId="showConfig",
     *     security={
     *          {"bearerAuth": {}}
     *     },
     *     @OA\Parameter(
     *         description="ID of Config",
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
     *      description="Single Config.",
     *          @OA\JsonContent(type="object",
     *          @OA\Property(property="code", type="integer"),
     *          @OA\Property(property="message", type="string"),
     *          @OA\Property(property="data", type="array",
     *          @OA\Items(type="object",
     *              @OA\Property(property="pageTitle", type="string"),
     *              @OA\Property(property="pageDescription", type="string"),
     *                    ),
     *                ),
     *            ),
     *
     *      ),
     *     @OA\Response(response=404, description="Not Found"),
     *     @OA\Response(response=500, description="Token has expired | Internal Server error")
     * )
     */
    public function show(int $id)
    {
        return new ShowResource($this->configService->find($id));
    }
}
