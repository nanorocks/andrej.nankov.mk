<?php

namespace App\Http\Requests\Auth;

use App\Domain\Dtos\Auth\LoginDto;
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
                'reCaptcha' => 'required'
            ]
        );

        parent::__construct($request);
    }

    public function convertToDto(): LoginDto
    {
        return LoginDto::fromRequest($this);
    }
}
