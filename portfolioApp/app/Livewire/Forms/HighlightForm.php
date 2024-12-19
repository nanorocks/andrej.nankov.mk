<?php

namespace App\Livewire\Forms;

use App\Models\Highlight;
use Livewire\Form;

class HighlightForm extends Form
{
    public ?Highlight $highlightModel;
    
    public $year = '';
    public $event = '';

    public function rules(): array
    {
        return [
			'year' => 'required',
			'event' => 'required|string',
        ];
    }

    public function setHighlightModel(Highlight $highlightModel): void
    {
        $this->highlightModel = $highlightModel;
        
        $this->year = $this->highlightModel->year;
        $this->event = $this->highlightModel->event;
    }

    public function store(): void
    {
        $this->highlightModel->create($this->validate());

        $this->reset();
    }

    public function update(): void
    {
        $this->highlightModel->update($this->validate());

        $this->reset();
    }
}
