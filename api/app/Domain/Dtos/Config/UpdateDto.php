<?php

namespace App\Domain\Dtos\Config;

use App\Models\Config;
use App\Http\Requests\Config\UpdateRequest;
use Spatie\DataTransferObject\DataTransferObject;

class UpdateDto extends DataTransferObject
{
    public string $pageTitle;

    public string $pageDescription;

    public static function fromRequest(UpdateRequest $request): self
    {
        return new self([
            Config::PAGE_TITLE => $request->getParams()->pageTitle,
            Config::PAGE_DESCRIPTION => $request->getParams()->pageDescription
        ]);
    }
}
