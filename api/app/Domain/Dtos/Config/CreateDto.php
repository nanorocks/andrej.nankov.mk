<?php

namespace App\Domain\Dtos\Config;

use App\Http\Requests\Config\StoreRequest;
use Spatie\DataTransferObject\DataTransferObject;

class CreateDto extends DataTransferObject
{
    public string $pageTitle;

    public string $pageDescription;

    public static function fromRequest(StoreRequest $request): self
    {
        return new self([
            'pageTitle' => $request->getParams()->pageTitle,
            'pageDescription' => $request->getParams()->pageDescription
        ]);
    }
}
