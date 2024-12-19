<?php

namespace App\Livewire\Forms;

use App\Models\Service;
use Livewire\Form;

class ServiceForm extends Form
{
    public ?Service $serviceModel;
    
    public $title = '';
    public $description = '';
    public $price = '';
    public $photo_url = '';
    public $icon = '';
    public $slug = '';

    public function rules(): array
    {
        return [
			'title' => 'required|string',
			'description' => 'required|string',
			'price' => 'required',
			'photo_url' => 'string',
			'icon' => 'string',
			'slug' => 'required|string',
        ];
    }

    public function setServiceModel(Service $serviceModel): void
    {
        $this->serviceModel = $serviceModel;
        
        $this->title = $this->serviceModel->title;
        $this->description = $this->serviceModel->description;
        $this->price = $this->serviceModel->price;
        $this->photo_url = $this->serviceModel->photo_url;
        $this->icon = $this->serviceModel->icon;
        $this->slug = $this->serviceModel->slug;
    }

    public function store(): void
    {
        $this->serviceModel->create($this->validate());

        $this->reset();
    }

    public function update(): void
    {
        $this->serviceModel->update($this->validate());

        $this->reset();
    }
}
