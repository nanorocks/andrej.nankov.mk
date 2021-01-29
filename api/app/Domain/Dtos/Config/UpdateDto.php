<?php

namespace App\Domain\Dtos\Config;

use App\Http\Requests\Config\UpdateRequest;
use Spatie\DataTransferObject\DataTransferObject;

class UpdateDto extends DataTransferObject
{
    public string $pageTitle;

    public string $pageDescription;

    public static function fromRequest(UpdateRequest $request): self
    {
        return new self([
            'pageTitle' => $request->getParams()->pageTitle,
            'pageDescription' => $request->getParams()->pageDescription
        ]);
    }
}
