<?php

namespace App\Livewire\Helpers;

trait Modal
{
    public $showModal = false;
    public $editMode = false;

    public function modalClose()
    {
        $this->showModal = false;
        $this->clean();
    }
}