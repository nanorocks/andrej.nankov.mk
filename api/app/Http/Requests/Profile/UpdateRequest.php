<?php

namespace App\Http\Requests\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;

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
                User::HIGHLIGHTS => 'required',
                User::ADDRESS => 'required',
                User::PHONE => 'required',
            ]
        );

        parent::__construct($request);
    }
}
