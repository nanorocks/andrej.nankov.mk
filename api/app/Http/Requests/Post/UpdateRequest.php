<?php

namespace App\Http\Requests\Post;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Post;

class UpdateRequest extends Controller
{
    public function __construct(Request $request)
    {
        $this->validate(
            $request,
            [
                Post::TITLE => 'required',
                Post::UNIQUE_ID => 'required',
                Post::SUB_TITLE => 'required',
                Post::TEXT => 'required',
                Post::DATE => 'required',
                Post::STATUS => 'required',
                Post::REFERENCES => 'required',
                Post::IMAGE => 'required',
                Post::META_BUDGES => 'required',
                Post::CATEGORY => 'required',
                Post::USER_ID => 'required',
            ]
        );

        parent::__construct($request);
    }
}
