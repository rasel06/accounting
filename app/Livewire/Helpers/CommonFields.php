<?php

namespace App\Livewire\Helpers;

use NumberToWords\NumberToWords;
use Carbon\Carbon;


trait CommonFields
{
    public $id;
    public $userId;
    public $statusList = ['active' => 'Active', 'inactive' => 'In Active'];
    public $status = 'active';

    public $selectedItem;

    public $addMode = false;
    public $editMode = false;


    // ---------------------- Table Filter Attributes ------------ >
    public $statusFilter = "";
    public $nameFilter = "";
    public $limitFilter = 10;


    /***
     * Clean the Common Fields
     * id, status,errors
     */
    public function commonReset()
    {
        $this->id = null;
        $this->status = 'active';
        $this->resetErrorBag();
    }


    public function camelToSnake($input)
    {
        return strtolower(preg_replace('/(?<!^)[A-Z]/', '_$0', $input));
    }

    public function convertToWords($number)
    {
        return ucwords(strtolower(NumberToWords::transformNumber('en', $number, 'USD')));
    }

    public function convertDate($dateString)
    {
        $date = Carbon::createFromFormat('Y-m-d', $dateString);
        $formattedDate = $date->format('M jS, Y');
        return $formattedDate;
    }
}
