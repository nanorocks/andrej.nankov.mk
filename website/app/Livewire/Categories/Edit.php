<?php

namespace App\Livewire\Categories;

use App\Livewire\Forms\CategoryForm;
use App\Models\Category;
use Livewire\Attributes\Layout;
use Livewire\Component;

class Edit extends Component
{
    public CategoryForm $form;

    public function mount(Category $category)
    {
        $this->form->setCategoryModel($category);
    }

    public function save()
    {
        $this->form->update();

        return $this->redirectRoute('categories.index', navigate: true);
    }

    #[Layout('layouts.app')]
    public function render()
    {
        return view('livewire.category.edit');
    }
}
