<?php

namespace App\Livewire\Helpers;

trait Modal
{
    use CommonFields;

    public $showModal = false;

    public function resetFields()
    {
        $this->resetErrorBag();
        $this->resetInputFields();
    }


    public function modalClose()
    {
        $this->showModal = false;
        $this->resetErrorBag();
        $this->resetInputFields();
    }
}
