<?php

namespace App\Livewire\Forms;

use App\Models\Category;
use Livewire\Form;

class CategoryForm extends Form
{
    public ?Category $categoryModel;
    
    public $name = '';
    public $slug = '';
    public $description = '';
    public $parent_id = '';
    public $story_count = '';

    public function rules(): array
    {
        return [
			'name' => 'required|string',
			'slug' => 'required|string',
			'description' => 'string',
			'story_count' => 'required',
        ];
    }

    public function setCategoryModel(Category $categoryModel): void
    {
        $this->categoryModel = $categoryModel;
        
        $this->name = $this->categoryModel->name;
        $this->slug = $this->categoryModel->slug;
        $this->description = $this->categoryModel->description;
        $this->parent_id = $this->categoryModel->parent_id;
        $this->story_count = $this->categoryModel->story_count;
    }

    public function store(): void
    {
        $this->categoryModel->create($this->validate());

        $this->reset();
    }

    public function update(): void
    {
        $this->categoryModel->update($this->validate());

        $this->reset();
    }
}
