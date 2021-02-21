<?php

namespace App\Domain\Dtos\Auth;

use ReallySimpleJWT\Token;
use App\Http\Requests\Auth\RefreshTokenRequest;
use Spatie\DataTransferObject\DataTransferObject;

class RefreshTokenDto extends DataTransferObject
{
    public array $token;

    public static function fromRequest(RefreshTokenRequest $request): self
    {
        return new self([
            'token' => Token::getPayload($request->getParams()->get('token'), env('JWT_SECRET')),
        ]);
    }
}
