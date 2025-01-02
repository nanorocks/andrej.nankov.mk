<?php

namespace App\Livewire\Categories;

use App\Livewire\Forms\CategoryForm;
use App\Models\Category;
use Livewire\Attributes\Layout;
use Livewire\Component;

class Show extends Component
{
    public CategoryForm $form;

    public function mount(Category $category)
    {
        $this->form->setCategoryModel($category);
    }

    #[Layout('layouts.app')]
    public function render()
    {
        return view('livewire.category.show', ['category' => $this->form->categoryModel]);
    }
}
