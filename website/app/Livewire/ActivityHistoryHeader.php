<?php

namespace App\Livewire;

use Livewire\Component;

class ActivityHistoryHeader extends Component
{

    public function flush()
    {
        \App\Models\Activity::truncate(); // or your service method

        $this->dispatch('activities-flushed', message: 'Activities cleared successfully!', type: 'success');
    }

    public function render()
    {
        return view('livewire.activity-history-header');
    }
}
