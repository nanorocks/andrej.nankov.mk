<?php

namespace App\Http\Controllers;

use App\Http\Requests\RequestInterface;
use Illuminate\Http\Request;
use Laravel\Lumen\Routing\Controller as BaseController;

class Controller extends BaseController implements RequestInterface
{

    /**
     * @license Apache 2.0
     * @OA\Info(
     * description="Api designed for personal blog site",
     * version="1.0.0",
     * title="Blog api",
     * @OA\Contact(
     * email="andrejnankov@gmail.com"
     * ),
     * @OA\License(
     * name="Licence",
     * url="#"
     * )
     * )
     * @OA\Server(
     * description="Blog API Server",
     * url="http://homestead.test"
     * )
     *
     * @OA\SecurityScheme(
     * securityScheme="bearerAuth",
     * in="header",
     * type="http",
     * scheme="bearer",
     * bearerFormat="JWT",
     * )
     */

    protected $service;
    protected $params;
    public $request;

    public function __construct(Request $request)
    {
        $this->params = $request->all();
        $this->request = $request;
    }

    /**
     * Return the Request Object
     *
     * @return \Illuminate\Http\Request
     */
    public function getParams(): Request
    {
        return $this->request->replace($this->params);
    }
}
