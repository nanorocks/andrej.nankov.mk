<?php

namespace App\Livewire\SeoPages;

use App\Models\SeoPage;
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
        $seoPages = SeoPage::paginate();

        return view('livewire.seo-page.index', compact('seoPages'))
            ->with('i', $this->getPage() * $seoPages->perPage());
    }

    public function delete(SeoPage $seoPage)
    {
        $seoPage->delete();

        return $this->redirectRoute('seo-pages.index', navigate: true);
    }
}
