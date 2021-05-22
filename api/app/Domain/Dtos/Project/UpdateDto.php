<?php

namespace App\Domain\Dtos\Project;

use App\Models\Project;
use App\Http\Requests\Project\UpdateRequest;
use Spatie\DataTransferObject\DataTransferObject;

class UpdateDto extends DataTransferObject
{
    public string $title;
    public string $description;
    public string $date;
    public string $status;
    public string $link;
    public ?string $image;
    public int $userId;

    public static function fromRequest(UpdateRequest $request): self
    {
        return new self([
            Project::TITLE => $request->getParams()->title,
            Project::DESCRIPTION => $request->getParams()->description,
            Project::DATE => $request->getParams()->date,
            Project::STATUS => $request->getParams()->status,
            Project::LINK => $request->getParams()->link,
            Project::IMAGE => empty($request->getParams()->image) ? null : $request->getParams()->image,,
            Project::USER_ID => $request->userId
        ]);
    }
}
