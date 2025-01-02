<?php

namespace App\Livewire\Services;

use App\Livewire\Forms\ServiceForm;
use App\Models\Service;
use Livewire\Attributes\Layout;
use Livewire\Component;

class Show extends Component
{
    public ServiceForm $form;

    public function mount(Service $service)
    {
        $this->form->setServiceModel($service);
    }

    #[Layout('layouts.app')]
    public function render()
    {
        return view('livewire.service.show', ['service' => $this->form->serviceModel]);
    }
}
