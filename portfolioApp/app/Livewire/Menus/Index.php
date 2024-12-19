<?php

namespace App\Livewire\Menus;

use App\Models\Menu;
use Illuminate\View\View;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    #[Layout('layouts.app')]
    public function render(): View
    {
        $menus = Menu::paginate();

        return view('livewire.menu.index', compact('menus'))
            ->with('i', $this->getPage() * $menus->perPage());
    }

    public function delete(Menu $menu)
    {
        $menu->delete();

        return $this->redirectRoute('menus.index', navigate: true);
    }
}
