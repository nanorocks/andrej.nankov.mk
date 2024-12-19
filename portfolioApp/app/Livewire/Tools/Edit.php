<?php

namespace App\Livewire\Tools;

use App\Livewire\Forms\ToolForm;
use App\Models\Tool;
use Livewire\Attributes\Layout;
use Livewire\Component;

class Edit extends Component
{
    public ToolForm $form;

    public function mount(Tool $tool)
    {
        $this->form->setToolModel($tool);
    }

    public function save()
    {
        $this->form->update();

        return $this->redirectRoute('tools.index', navigate: true);
    }

    #[Layout('layouts.app')]
    public function render()
    {
        return view('livewire.tool.edit');
    }
}
