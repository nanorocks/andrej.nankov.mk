<?php

namespace App\Livewire;

use App\Models\LsArticle;
use Livewire\Component;

class LinkShareDataTable extends Component
{
    public function render()
    {
        $articles = LsArticle::with(['categories'])->get();

        return view('livewire.link-share-data-table', compact('articles'));
    }
}