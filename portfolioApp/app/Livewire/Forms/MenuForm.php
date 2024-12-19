<?php

namespace App\Livewire\Forms;

use App\Models\Menu;
use Livewire\Form;

class MenuForm extends Form
{
    public ?Menu $menuModel;
    
    public $title = '';
    public $slug = '';
    public $url = '';
    public $parent_id = '';
    public $order = '';

    public function rules(): array
    {
        return [
			'title' => 'required|string',
			'slug' => 'required|string',
			'url' => 'string',
			'order' => 'required',
        ];
    }

    public function setMenuModel(Menu $menuModel): void
    {
        $this->menuModel = $menuModel;
        
        $this->title = $this->menuModel->title;
        $this->slug = $this->menuModel->slug;
        $this->url = $this->menuModel->url;
        $this->parent_id = $this->menuModel->parent_id;
        $this->order = $this->menuModel->order;
    }

    public function store(): void
    {
        $this->menuModel->create($this->validate());

        $this->reset();
    }

    public function update(): void
    {
        $this->menuModel->update($this->validate());

        $this->reset();
    }
}
