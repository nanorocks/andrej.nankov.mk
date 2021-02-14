<?php

namespace App\Http\Requests\Profile;

use App\Models\User;
use ReallySimpleJWT\Token;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Domain\Dtos\Profile\UpdateDto;

class UpdateRequest extends Controller
{
    public function __construct(Request $request)
    {
        $this->validate(
            $request,
            [
                User::EMAIL => 'required',
                User::NAME => 'required',
                User::INTRO => 'required',
                User::SUMMARY => 'required',
                User::CURRENT_WORK => 'required',
                User::TOP_PROGRAMMING_LANGUAGES => 'required',
                User::GOALS => 'required',
                User::QUOTES => 'required',
                User::SOC_MEDIA => 'required',
                User::HIGHLIGHTS => 'nullable',
                User::ADDRESS => 'required',
                User::PHONE => 'required',
            ]
        );

        parent::__construct($request);
    }

    public function convertToDto(): UpdateDto
    {
        $this->userId = Token::getPayload($this->request->bearerToken(), env('JWT_SECRET'))['user_id'];
        return UpdateDto::fromRequest($this);
    }
}
