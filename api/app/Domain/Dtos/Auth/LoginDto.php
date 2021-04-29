<?php

namespace App\Domain\Dtos\Auth;

use App\Http\Requests\Auth\LoginRequest;
use App\Models\User;
use Spatie\DataTransferObject\DataTransferObject;

class LoginDto extends DataTransferObject
{
    public string $email;

    public string $password;

    public ?string $reCaptcha;

    public static function fromRequest(LoginRequest $request): self
    {
        return new self([
            User::EMAIL => $request->getParams()->email,
            User::PASSWORD => $request->getParams()->password,
            'reCaptcha' => $request->getParams()->reCaptcha
        ]);
    }
}
