<?php

namespace App\Http\Controllers\AdminSide;

use App\Models\Config;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Config\StoreRequest;
use App\Http\Requests\Config\UpdateRequest;
use App\Http\Resources\Config\ShowResource;
use App\Http\Resources\Config\IndexResource;
use App\Http\Resources\Config\DestroyResource;
use App\Http\Resources\Config\StoreResource;
use App\Http\Resources\Config\UpdateResource;

class ConfigController extends Controller
{

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
        return new StoreResource(Config::create($request->convertToDto()->toArray()));
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
        $config = Config::find($id);
        $config->update($request->convertToDto()->toArray());
        return new UpdateResource($config);
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
        $config = Config::findOrFail($id);
        $config->delete();
        return new DestroyResource($config);
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
        $limit = $request->input('limit') ?? 4;
        return new IndexResource(Config::paginate($limit));
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
        return new ShowResource(Config::find($id));
    }
}
