<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\Attributes\On;

class NotificationBanner extends Component
{
    public ?string $message = null;
    public string $type = 'success';

    #[On('activities-flushed')]
    public function flash(string $message, string $type = 'success')
    {
        session()->flash($type, $message);
    }

    public function render()
    {
        return view('livewire.notification-banner');
    }
}
