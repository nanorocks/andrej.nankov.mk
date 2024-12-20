<?php

namespace App\Livewire\Menus;

use App\Livewire\Forms\MenuForm;
use App\Models\Menu;
use Livewire\Attributes\Layout;
use Livewire\Component;

class Create extends Component
{
    public MenuForm $form;

    public function mount(Menu $menu)
    {
        $this->form->setMenuModel($menu);
    }

    public function save()
    {
        $this->form->store();

        return $this->redirectRoute('menus.index', navigate: true);
    }

    #[Layout('layouts.app')]
    public function render()
    {
        return view('livewire.menu.create');
    }
}