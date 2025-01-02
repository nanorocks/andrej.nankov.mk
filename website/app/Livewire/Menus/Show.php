<?php

namespace App\Livewire\Menus;

use App\Livewire\Forms\MenuForm;
use App\Models\Menu;
use Livewire\Attributes\Layout;
use Livewire\Component;

class Show extends Component
{
    public MenuForm $form;

    public function mount(Menu $menu)
    {
        $this->form->setMenuModel($menu);
    }

    #[Layout('layouts.app')]
    public function render()
    {
        return view('livewire.menu.show', ['menu' => $this->form->menuModel]);
    }
}
