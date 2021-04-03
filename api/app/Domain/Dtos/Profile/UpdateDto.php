<?php

namespace App\Domain\Dtos\Profile;

use App\Models\User;
use App\Http\Requests\Profile\UpdateRequest;
use Spatie\DataTransferObject\DataTransferObject;

class UpdateDto extends DataTransferObject
{
    public string $email;
    public string $name;
    public string $photo;
    public string $intro;
    public string $summary;
    public string $currentWork;
    public string $topProgrammingLanguages;
    public string $goals;
    public array $quotes;
    public array $socMedia;
    public string $highlights;
    public string $address;
    public string $phone;
    public int $id;

    public static function fromRequest(UpdateRequest $request): self
    {
        return new self([
            User::EMAIL => $request->getParams()->email,
            User::NAME => $request->getParams()->name,
            User::PHOTO => $request->getParams()->photo,
            User::INTRO => html_entity_decode($request->getParams()->intro),
            User::SUMMARY => html_entity_decode($request->getParams()->summary),
            User::CURRENT_WORK => html_entity_decode($request->getParams()->currentWork),
            User::TOP_PROGRAMMING_LANGUAGES => $request->getParams()->topProgrammingLanguages,
            User::GOALS => $request->getParams()->goals,
            User::QUOTES => $request->getParams()->quotes,
            User::SOC_MEDIA => $request->getParams()->socMedia,
            User::HIGHLIGHTS => html_entity_decode($request->getParams()->highlights),
            User::ADDRESS => $request->getParams()->address,
            User::PHONE => $request->getParams()->phone,
            'id' => $request->userId
        ]);
    }
}
