<?php

namespace App\Http\Requests\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class RefreshTokenRequest extends Controller
{
    public function __construct(Request $request)
    {
        $this->validate(
            $request,
            [
                'token' => 'required',
            ]
        );

        parent::__construct($request);
    }
}
