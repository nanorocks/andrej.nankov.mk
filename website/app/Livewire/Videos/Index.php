<?php

namespace App\Livewire\Videos;

use App\Models\Video;
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
        $videos = Video::paginate();

        return view('livewire.video.index', compact('videos'))
            ->with('i', $this->getPage() * $videos->perPage());
    }

    public function delete(Video $video)
    {
        $video->delete();

        return $this->redirectRoute('videos.index', navigate: true);
    }
}
