<?php

namespace App\Livewire\Forms;

use App\Models\Tool;
use Livewire\Form;

class ToolForm extends Form
{
    public ?Tool $toolModel;
    
    public $title = '';
    public $slug = '';
    public $description = '';
    public $photo_url = '';
    public $caption = '';
    public $website_url = '';

    public function rules(): array
    {
        return [
			'title' => 'required|string',
			'slug' => 'required|string',
			'description' => 'string',
			'photo_url' => 'required|string',
			'caption' => 'string',
			'website_url' => 'string',
        ];
    }

    public function setToolModel(Tool $toolModel): void
    {
        $this->toolModel = $toolModel;
        
        $this->title = $this->toolModel->title;
        $this->slug = $this->toolModel->slug;
        $this->description = $this->toolModel->description;
        $this->photo_url = $this->toolModel->photo_url;
        $this->caption = $this->toolModel->caption;
        $this->website_url = $this->toolModel->website_url;
    }

    public function store(): void
    {
        $this->toolModel->create($this->validate());

        $this->reset();
    }

    public function update(): void
    {
        $this->toolModel->update($this->validate());

        $this->reset();
    }
}
