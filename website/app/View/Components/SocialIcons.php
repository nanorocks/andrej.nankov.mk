<?php

namespace App\View\Components;

use Illuminate\View\Component;

class SocialIcons extends Component
{
    public $links;

    public function __construct()
    {
        $this->links = \App\Models\SocialLink::getActiveSocialLinks();
    }

    public function render()
    {
        return view('components.social-icons');
    }
}
