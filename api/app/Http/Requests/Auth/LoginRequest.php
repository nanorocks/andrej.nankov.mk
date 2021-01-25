<?php

namespace App\Http\Requests\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;

class LoginRequest extends Controller
{
    public function __construct(Request $request)
    {
        $this->validate(
            $request,
            [
                User::EMAIL => 'required|email',
                User::PASSWORD => 'required',
            ]
        );

        parent::__construct($request);
    }
}
