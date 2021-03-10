<?php

namespace App\Domain\Dtos\Profile;

use App\Http\Requests\Profile\UpdateRequest;
use Spatie\DataTransferObject\DataTransferObject;

class UpdateDto extends DataTransferObject
{
    public string $email;
    public string $name;
    public string $intro;
    public string $summary;
    public string $currentWork;
    public string $topProgrammingLanguages;
    public string $goals;
    public string $quotes;
    public string $socMedia;
    public string $highlights;
    public string $address;
    public string $phone;
    public int $id;

    public static function fromRequest(UpdateRequest $request): self
    {
        return new self([
            'email' => $request->getParams()->email,
            'name' => $request->getParams()->name,
            'intro' => html_entity_decode($request->getParams()->intro),
            'summary' => html_entity_decode($request->getParams()->summary),
            'currentWork' => html_entity_decode($request->getParams()->currentWork),
            'topProgrammingLanguages' => $request->getParams()->topProgrammingLanguages,
            'goals' => $request->getParams()->goals,
            'quotes' => $request->getParams()->quotes,
            'socMedia' => $request->getParams()->socMedia,
            'highlights' => html_entity_decode($request->getParams()->highlights),
            'address' => $request->getParams()->address,
            'phone' => $request->getParams()->phone,
            'id' => $request->userId
        ]);
    }
}
