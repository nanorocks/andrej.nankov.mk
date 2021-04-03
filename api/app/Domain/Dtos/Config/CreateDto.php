<?php

namespace App\Domain\Dtos\Config;

use App\Http\Requests\Config\StoreRequest;
use App\Models\Config;
use Spatie\DataTransferObject\DataTransferObject;

class CreateDto extends DataTransferObject
{
    public string $pageTitle;

    public string $pageDescription;

    public static function fromRequest(StoreRequest $request): self
    {
        return new self([
            Config::PAGE_TITLE => $request->getParams()->pageTitle,
            Config::PAGE_DESCRIPTION => $request->getParams()->pageDescription
        ]);
    }
}
