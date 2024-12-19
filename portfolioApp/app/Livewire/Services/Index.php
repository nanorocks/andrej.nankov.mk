<?php

namespace App\Livewire\Services;

use App\Models\Service;
use Illuminate\View\View;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    #[Layout('layouts.app')]
    public function render(): View
    {
        $services = Service::paginate();

        return view('livewire.service.index', compact('services'))
            ->with('i', $this->getPage() * $services->perPage());
    }

    public function delete(Service $service)
    {
        $service->delete();

        return $this->redirectRoute('services.index', navigate: true);
    }
}
