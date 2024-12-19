<?php

namespace App\Livewire\Tools;

use App\Models\Tool;
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
        $tools = Tool::paginate();

        return view('livewire.tool.index', compact('tools'))
            ->with('i', $this->getPage() * $tools->perPage());
    }

    public function delete(Tool $tool)
    {
        $tool->delete();

        return $this->redirectRoute('tools.index', navigate: true);
    }
}
