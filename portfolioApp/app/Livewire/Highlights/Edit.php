<?php

namespace App\Livewire\Highlights;

use App\Livewire\Forms\HighlightForm;
use App\Models\Highlight;
use Livewire\Attributes\Layout;
use Livewire\Component;

class Edit extends Component
{
    public HighlightForm $form;

    public function mount(Highlight $highlight)
    {
        $this->form->setHighlightModel($highlight);
    }

    public function save()
    {
        $this->form->update();

        return $this->redirectRoute('highlights.index', navigate: true);
    }

    #[Layout('layouts.app')]
    public function render()
    {
        return view('livewire.highlight.edit');
    }
}