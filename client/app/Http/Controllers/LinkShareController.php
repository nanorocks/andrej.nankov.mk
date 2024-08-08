<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LinkShareController extends Controller
{
    //
    public function __invoke()
    {
        return view('link-share');
    }
}
