<?php

namespace App\Livewire\Stories;

use App\Livewire\Forms\StoryForm;
use App\Models\Story;
use Livewire\Attributes\Layout;
use Livewire\Component;

class Edit extends Component
{
    public StoryForm $form;

    public function mount(Story $story)
    {
        $this->form->setStoryModel($story);
    }

    public function save()
    {
        $this->form->update();

        return $this->redirectRoute('stories.index', navigate: true);
    }

    #[Layout('layouts.app')]
    public function render()
    {
        return view('livewire.story.edit');
    }
}
