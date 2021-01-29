<?php

namespace App\Domain\Dtos\Post;

use App\Helpers\GenerateUniqueId;
use App\Http\Requests\Post\UpdateRequest;
use Spatie\DataTransferObject\DataTransferObject;

class UpdateDto extends DataTransferObject
{
    public string $title;
    public string $unique_id;
    public string $subTitle;
    public string $text;
    public string $date;
    public string $status;
    public string $references;
    public string $image;
    public string $metaBudges;
    public string $category;
    public int $userId;

    public static function fromRequest(UpdateRequest $request): self
    {
        return new self([
            'title' => $request->getParams()->title,
            'unique_id' => GenerateUniqueId::uuid(),
            'subTitle' => $request->getParams()->subTitle,
            'text' => $request->getParams()->text,
            'date' => $request->getParams()->date,
            'status' => $request->getParams()->status,
            'references' => $request->getParams()->references,
            'image' => $request->getParams()->image,
            'metaBudges' => $request->getParams()->metaBudges,
            'category' => $request->getParams()->category,
            'userId' => $request->userId
        ]);
    }
}
