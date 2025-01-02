<?php

namespace App\Livewire\Forms;

use App\Models\Project;
use Livewire\Form;
use Carbon\Carbon;
use Illuminate\Support\Str;

class ProjectForm extends Form
{
    public ?Project $projectModel;

    public $slug = '';
    public $title = '';
    public $description = '';
    public $start_date = '';
    public $end_date = '';
    public $project_url = '';
    public $image_url = '';
    public $status = '';
    public $user_id = '';

    public function rules(): array
    {
        return [
            'slug' => 'required|string',
            'title' => 'required|string',
            'description' => 'required|string',
            'start_date' => 'required',
            'end_date' => 'nullable|string',
            'project_url' => 'string',
            'image_url' => 'string',
            'status' => 'required',
            'user_id' => 'required',
        ];
    }

    public function setProjectModel(Project $projectModel): void
    {
        $this->projectModel = $projectModel;

        $this->slug = $this->projectModel->slug;
        $this->title = $this->projectModel->title;
        $this->description = $this->projectModel->description;
        $this->start_date = $this->projectModel->start_date;
        $this->end_date = $this->projectModel->end_date;
        $this->project_url = $this->projectModel->project_url;
        $this->image_url = $this->projectModel->image_url;
        $this->status = $this->projectModel->status;
        $this->user_id = $this->projectModel->user_id;
    }

    public function store(): void
    {
        $validatedData = $this->validate();
        $validatedData['start_date'] = Carbon::createFromFormat('d-M-Y', $validatedData['start_date'])->format('Y-m-d');
        if (!empty($validatedData['end_date'])) {
            $validatedData['end_date'] = Carbon::createFromFormat('d-M-Y', $validatedData['end_date'])->format('Y-m-d');
        }
        $validatedData['uuid'] = Str::uuid();

        $this->projectModel->create($validatedData);

        $this->reset();
    }

    public function update(): void
    {
        $validatedData = $this->validate();
        $validatedData['start_date'] = Carbon::createFromFormat('d-M-Y', $validatedData['start_date'])->format('Y-m-d');
        if (!empty($validatedData['end_date'])) {
            $validatedData['end_date'] = Carbon::createFromFormat('d-M-Y', $validatedData['end_date'])->format('Y-m-d');
        }

        $this->projectModel->update($validatedData);

        $this->reset();
    }
}