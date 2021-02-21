<?php

namespace App\Http\Requests\Auth;

use App\Domain\Dtos\Auth\RefreshTokenDto;
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

    public function convertToDto(): RefreshTokenDto
    {
        return RefreshTokenDto::fromRequest($this);
    }
}
