<?php

namespace App\View\Components;

use Closure;
use App\Models\SocialLink;
use Illuminate\View\Component;
use Illuminate\Contracts\View\View;

class SocialIcons extends Component
{
    public $links;

    public function __construct()
    {
        $this->links = SocialLink::where('active', true)->get();

    }

    public function render()
    {
        return view('components.social-icons');
    }
}
