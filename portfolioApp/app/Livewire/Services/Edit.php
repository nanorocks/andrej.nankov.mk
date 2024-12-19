<?php

namespace App\Livewire\Services;

use App\Livewire\Forms\ServiceForm;
use App\Models\Service;
use Livewire\Attributes\Layout;
use Livewire\Component;

class Edit extends Component
{
    public ServiceForm $form;

    public function mount(Service $service)
    {
        $this->form->setServiceModel($service);
    }

    public function save()
    {
        $this->form->update();

        return $this->redirectRoute('services.index', navigate: true);
    }

    #[Layout('layouts.app')]
    public function render()
    {
        return view('livewire.service.edit');
    }
}
