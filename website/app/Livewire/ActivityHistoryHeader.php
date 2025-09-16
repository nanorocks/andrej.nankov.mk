<?php

namespace App\Livewire;

use Livewire\Component;

class ActivityHistoryHeader extends Component
{
    public string $search = '';
    public ?string $logName = null;
    public ?string $event = null;
    public ?string $dateFrom = null;
    public ?string $dateTo = null;

    public function flush()
    {
        \App\Models\Activity::truncate();

        $this->dispatch('activities-flushed', message: 'Activities cleared successfully!', type: 'success');
    }

    public function updateFilters()
    {
        $this->dispatch('filters-updated', [
            'search'   => $this->search,
            'logName'  => $this->logName,
            'event'    => $this->event,
            'dateFrom' => $this->dateFrom,
            'dateTo'   => $this->dateTo,
        ]);
    }

    public function resetFilters()
    {
        $this->reset(['search', 'logName', 'event', 'dateFrom', 'dateTo']);
        $this->dispatch('filters-updated', [
            'search'   => '',
            'logName'  => null,
            'event'    => null,
            'dateFrom' => null,
            'dateTo'   => null,
        ]);
    }

    public function render()
    {
        return view('livewire.activity-history-header', [
            'logNames' => \App\Models\Activity::query()->select('log_name')->distinct()->pluck('log_name'),
            'events'   => \App\Models\Activity::query()->select('event')->distinct()->pluck('event'),
        ]);
    }
}
