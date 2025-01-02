<?php

namespace App\Livewire\Stories;

use App\Livewire\Forms\StoryForm;
use App\Models\Story;
use Livewire\Attributes\Layout;
use Livewire\Component;

class Show extends Component
{
    public StoryForm $form;

    public function mount(Story $story)
    {
        $this->form->setStoryModel($story);
    }

    #[Layout('layouts.app')]
    public function render()
    {
        return view('livewire.story.show', ['story' => $this->form->storyModel]);
    }
}
