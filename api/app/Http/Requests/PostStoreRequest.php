<?php

namespace App\Http\Requests;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PostStoreRequest extends Controller
{
    public function __construct(Request $request)
    {
        $this->validate(
            $request,
            [
                // 'email' => 'required|email',
                // 'password' => 'required',
            ]
        );

        parent::__construct($request);
    }
}
