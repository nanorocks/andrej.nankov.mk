<?php

namespace App\Http\Requests\Config;

use App\Domain\Dtos\Config\CreateDto;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Config;

class StoreRequest extends Controller
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

    public function convertToDto(): CreateDto
    {
        return CreateDto::fromRequest($this);
    }
}
