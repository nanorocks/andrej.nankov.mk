<?php

namespace App\Services;

use App\Domain\Dtos\Auth\LoginDto;
use Illuminate\Support\Facades\Http;

class ReCaptchaService
{
    public const URI = 'https://www.google.com/recaptcha/api/siteverify';

    public function validateReCaptcha(LoginDto $dto)
    {
        $response = Http::asForm()
            ->post(self::URI, [
                'secret' => env('RECAPTCHA_SECRET'),
                'response' => $dto->reCaptcha,
            ])->json();

        return $response;
    }
}
