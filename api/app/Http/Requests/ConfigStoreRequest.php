<?php

namespace App\Http\Requests;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Config;

class ConfigStoreRequest extends Controller
{
    public function __construct(Request $request)
    {
        $this->validate(
            $request,
            [
                Config::PAGE_TITLE => 'required',
                Config::PAGE_DESCRIPTION => 'required',
            ]
        );

        parent::__construct($request);
    }
}
