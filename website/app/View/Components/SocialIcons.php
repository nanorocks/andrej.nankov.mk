<?php

namespace App\View\Components;

use Illuminate\View\Component;

class SocialIcons extends Component
{
    public $links;

    public function __construct()
    {
        $this->links = \Illuminate\Support\Facades\Cache::remember(
            'active_social_links',
            now()->addMinutes(10),
            function () {
                return \App\Models\SocialLink::where('active', true)->get();
            }
        );
    }

    public function render()
    {
        return view('components.social-icons');
    }
}
