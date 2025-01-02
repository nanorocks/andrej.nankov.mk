<?php

namespace App\Livewire\SeoPages;

use App\Livewire\Forms\SeoPageForm;
use App\Models\SeoPage;
use Livewire\Attributes\Layout;
use Livewire\Component;

class Show extends Component
{
    public SeoPageForm $form;

    public function mount(SeoPage $seoPage)
    {
        $this->form->setSeoPageModel($seoPage);
    }

    #[Layout('layouts.app')]
    public function render()
    {
        return view('livewire.seo-page.show', ['seoPage' => $this->form->seoPageModel]);
    }
}
