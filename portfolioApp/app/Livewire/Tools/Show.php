<?php

namespace App\Livewire\Tools;

use App\Livewire\Forms\ToolForm;
use App\Models\Tool;
use Livewire\Attributes\Layout;
use Livewire\Component;

class Show extends Component
{
    public ToolForm $form;

    public function mount(Tool $tool)
    {
        $this->form->setToolModel($tool);
    }

    #[Layout('layouts.app')]
    public function render()
    {
        return view('livewire.tool.show', ['tool' => $this->form->toolModel]);
    }
}
