<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\Attributes\On;
use Filament\Notifications\Notification;

class NotificationBanner extends Component
{
    public ?string $message = null;
    public string $type = 'success';

    #[On('activities-flushed')]
    public function flash(string $message, string $type = 'success')
    {
        $recipient = auth()->user();

        Notification::make()
            ->title($message)
            ->icon($type === 'success' ? 'heroicon-o-check-circle' : 'heroicon-o-x-circle')
            ->iconColor($type === 'success' ? 'success' : 'danger')
            ->sendToDatabase($recipient);

        session()->flash($type, $message);
    }

    public function render()
    {
        return view('livewire.notification-banner');
    }
}
