<?php

namespace App\Livewire\Helpers;

trait Modal
{
    use CommonFields;

    public $showModal = false;
    public $editMode = false;

    public function modalClose()
    {
        $this->showModal = false;
        $this->resetErrorBag();
        $this->clean();
    }
}
