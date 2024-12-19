<?php

namespace App\Livewire\Stories;

use App\Models\Story;
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
        $stories = Story::paginate();

        return view('livewire.story.index', compact('stories'))
            ->with('i', $this->getPage() * $stories->perPage());
    }

    public function delete(Story $story)
    {
        $story->delete();

        return $this->redirectRoute('stories.index', navigate: true);
    }
}
