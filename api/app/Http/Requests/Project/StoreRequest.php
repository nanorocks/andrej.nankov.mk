<?php

namespace App\Http\Requests\Project;

use App\Models\Project;
use ReallySimpleJWT\Token;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Domain\Dtos\Project\CreateDto;

class StoreRequest extends Controller
{
    public function __construct(Request $request)
    {
        $this->validate(
            $request,
            [
                Project::TITLE => 'required',
                Project::DESCRIPTION => 'required',
                Project::DATE => 'required',
                Project::STATUS => 'required',
                Project::LINK => 'url',
                Project::IMAGE => 'image',
            ]
        );

        parent::__construct($request);
    }

    public function convertToDto(): CreateDto
    {
        $this->userId = Token::getPayload($this->request->bearerToken(), env('JWT_SECRET'))['user_id'];
        return CreateDto::fromRequest($this);
    }
}
