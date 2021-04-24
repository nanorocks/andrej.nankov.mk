<?php

namespace App\Domain\Dtos\Project;

use App\Http\Requests\Project\StoreRequest;
use App\Models\Project;
use Spatie\DataTransferObject\DataTransferObject;

class CreateDto extends DataTransferObject
{
    public string $title;
    public string $description;
    public string $date;
    public string $status;
    public string $link;
    public ?string $image;
    public int $userId;

    public static function fromRequest(StoreRequest $request): self
    {
        return new self([
            Project::TITLE => $request->getParams()->title,
            Project::DESCRIPTION => $request->getParams()->description,
            Project::DATE => $request->getParams()->date,
            Project::STATUS => $request->getParams()->status,
            Project::LINK => $request->getParams()->link,
            Project::IMAGE => $request->getParams()->image,
            Project::USER_ID => $request->userId
        ]);
    }

}
