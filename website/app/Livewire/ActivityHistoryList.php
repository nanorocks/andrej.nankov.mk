<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\Attributes\On;
use Livewire\WithPagination;
use Spatie\Activitylog\Models\Activity;

class ActivityHistoryList extends Component
{
    use WithPagination;

    #[On('filters-updated')]
    public function getActivitiesProperty($props)
    {
        dd($props);
        return Activity::query()->latest()->paginate(10);
    }

    public function render()
    {
        return view('livewire.activity-history-list', [
            'activities' => Activity::query()->latest()->paginate(10),
        ]);
    }
}
