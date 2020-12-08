<?php

namespace App\Http\Controllers;

use App\Http\Requests\FormRequestInterface;
use Illuminate\Http\Request;
use Laravel\Lumen\Routing\Controller as BaseController;

class Controller extends BaseController implements FormRequestInterface
{
    /**
     * @OA\Info(
     *      version="1.0.0",
     *      title="Blog api",
     *      description="Api designed for personal blog site"
     * )
     *
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
