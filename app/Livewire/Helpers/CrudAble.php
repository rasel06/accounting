<?php

namespace App\Livewire\Helpers;

use Illuminate\Database\Eloquent\Model;

trait CrudAble
{
    use Modal, Model;

    // public $id;
    public $userId;
    public $createMode = false;

    // public function create(Model $model)
    // {
    //     $data = $model->toArray();
    //     $this->showModal = true;
    // }

    // public function details($id)
    // {
    //     $this->id = $id;
    // }

    // public function edit($id)
    // {
    //     $this->id = $id;
    // }

    // public function delete($id)
    // {
    //     $this->id = $id;
    // }
}
