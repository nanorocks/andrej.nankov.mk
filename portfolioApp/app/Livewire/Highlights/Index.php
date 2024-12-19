<?php

namespace App\Livewire\Highlights;

use App\Models\Highlight;
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
        $highlights = Highlight::paginate();

        return view('livewire.highlight.index', compact('highlights'))
            ->with('i', $this->getPage() * $highlights->perPage());
    }

    public function delete(Highlight $highlight)
    {
        $highlight->delete();

        return $this->redirectRoute('highlights.index', navigate: true);
    }
}
