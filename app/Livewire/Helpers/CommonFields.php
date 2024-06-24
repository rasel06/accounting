<?php

namespace App\Livewire\Helpers;

use NumberToWords\NumberToWords;
use Carbon\Carbon;
use App\Models\CreditTransaction;
use App\Models\DebitTransaction;


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
        // One Hundred Twenty Two Dollars Ninety Four Cents
        $amount =  explode(".", $number);
        $result = "";

        if (sizeof($amount) == 2) {
            $dollars = NumberToWords::transformNumber('en', $amount[0]);
            $cents = NumberToWords::transformNumber('en', $amount[1]);
            $result =  "{$dollars} Dollars and {$cents} Cents";
        } else if (sizeof($amount) == 1) {
            $dollars = NumberToWords::transformNumber('en', $amount[0]);
            $result =  "{$dollars} Dollars";
        }

        $words = str_replace("-", " ", $result);
        return ucwords(strtolower($words));
    }

    public function convertDate($dateString)
    {
        $date = Carbon::createFromFormat('Y-m-d', $dateString);
        $formattedDate = $date->format('M jS, Y');
        return $formattedDate;
    }


    protected function generateNextInvoiceNumber($mode = "credit")
    {
        if ($mode === "credit") {
            $lastInvoice = CreditTransaction::orderBy('invoice_number', 'desc')->first();
            $invoicePrefix = 'DBC';
        } else {
            $lastInvoice = DebitTransaction::orderBy('invoice_number', 'desc')->first();
            $invoicePrefix = 'DBD';
        }

        $numericPart = 10001;

        if ($lastInvoice) {
            $lastInvoiceNumber = $lastInvoice->invoice_number;
            $numericPart = intval(substr($lastInvoiceNumber, 3));
        }

        $newInvoiceNumber = $numericPart + 1;
        $newInvoiceNumberFormatted = $invoicePrefix . str_pad($newInvoiceNumber, 6, '0', STR_PAD_LEFT);

        return $newInvoiceNumberFormatted;
    }
}
