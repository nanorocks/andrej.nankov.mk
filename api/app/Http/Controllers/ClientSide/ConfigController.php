<?php

namespace App\Http\Controllers\ClientSide;

use App\Models\Post;
use App\Models\Config;
use App\Services\ConfigService;
use App\Http\Controllers\Controller;
use App\Http\Resources\Config\IndexResource;

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
     * @OA\Get(
     *     path="/config",
     *     operationId="configUser",
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
     *     @OA\Response(response="200", description="Get information for config")
     * )
     */
    public function index()
    {
        return new IndexResource($this->configService->all([Config::PAGE_TITLE, Config::PAGE_DESCRIPTION]));
    }
}
