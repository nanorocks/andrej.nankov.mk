<?php

namespace App\Livewire\SeoPages;

use App\Livewire\Forms\SeoPageForm;
use App\Models\SeoPage;
use Livewire\Attributes\Layout;
use Livewire\Component;

class Edit extends Component
{
    public SeoPageForm $form;

    public function mount(SeoPage $seoPage)
    {
        $this->form->setSeoPageModel($seoPage);
    }

    public function save()
    {
        $this->form->update();

        return $this->redirectRoute('seo-pages.index', navigate: true);
    }

    #[Layout('layouts.app')]
    public function render()
    {
        return view('livewire.seo-page.edit');
    }
}
