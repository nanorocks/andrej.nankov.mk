<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use Spatie\Activitylog\Models\Activity;

class ActivityHistoryList extends Component
{
    use WithPagination;

    protected $listeners = ['activities-flushed' => '$refresh'];

    public function getActivitiesProperty()
    {
        return Activity::query()->latest()->paginate(10);
    }

    public function render()
    {
        return view('livewire.activity-history-list', [
            'activities' => $this->activities,
        ]);
    }
}
