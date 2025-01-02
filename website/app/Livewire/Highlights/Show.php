<?php

namespace App\Livewire\Highlights;

use App\Livewire\Forms\HighlightForm;
use App\Models\Highlight;
use Livewire\Attributes\Layout;
use Livewire\Component;

class Show extends Component
{
    public HighlightForm $form;

    public function mount(Highlight $highlight)
    {
        $this->form->setHighlightModel($highlight);
    }

    #[Layout('layouts.app')]
    public function render()
    {
        return view('livewire.highlight.show', ['highlight' => $this->form->highlightModel]);
    }
}
