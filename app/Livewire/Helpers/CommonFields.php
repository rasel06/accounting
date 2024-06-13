<?php

namespace App\Livewire\Helpers;

trait CommonFields
{
    public $id;
    public $userId;
    public $statusList = ['active' => 'Active', 'inactive' => 'In Active'];
    public $status = 'active';

    public $selectedItem;


    // ---------------------- Table Filter Attributes ------------ >
    public $statusFilter = "";
    public $nameFilter = "";
    public $limitFilter = 10;


    /***
     * Clean the Common Fields
     * id, status,errors
     */
    public function commonClean()
    {
        $this->id = null;
        $this->status = 'active';
        $this->resetErrorBag();
    }
}
