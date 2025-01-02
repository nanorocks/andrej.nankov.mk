<?php

namespace App\Livewire\Projects;

use App\Livewire\Forms\ProjectForm;
use App\Models\Project;
use Livewire\Attributes\Layout;
use Livewire\Component;

class Show extends Component
{
    public ProjectForm $form;

    public function mount(Project $project)
    {
        $this->form->setProjectModel($project);
    }

    #[Layout('layouts.app')]
    public function render()
    {
        return view('livewire.project.show', ['project' => $this->form->projectModel]);
    }
}
