<?php

namespace App\Http\Requests\Project;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Project;

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
                Project::LINK => 'required',
                Project::IMAGE => 'required',
                Project::USER_ID => 'required',
            ]
        );

        parent::__construct($request);
    }
}
