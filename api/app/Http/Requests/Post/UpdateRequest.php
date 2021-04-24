<?php

namespace App\Http\Requests\Post;

use App\Models\Post;
use ReallySimpleJWT\Token;
use Illuminate\Http\Request;
use App\Domain\Dtos\Post\UpdateDto;
use App\Http\Controllers\Controller;

class UpdateRequest extends Controller
{
    public function __construct(Request $request)
    {
        $this->validate(
            $request,
            [
                Post::TITLE => 'required',
                Post::SUB_TITLE => 'required',
                Post::TEXT => 'required',
                Post::DATE => 'required',
                Post::STATUS => 'required',
                Post::REFERENCES => 'required',
                Post::IMAGE => 'url',
                Post::META_BUDGES => 'required',
                Post::CATEGORY => 'required',
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
