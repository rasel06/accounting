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

    public $module = '';

    public $selectedItem;

    public $addMode = false;
    public $editMode = false;

    public function getModule()
    {
        $classPart = explode("\\", get_class());
        $this->module = $this->convertTextFromCamelCase(end($classPart));
    }


    // ---------------------- Table Filter Attributes ------------ >
    public $statusFilter = "";
    public $nameFilter = "";
    public $limitFilter = 10;


    public function commonReset()
    {
        $this->id = null;
        $this->status = 'active';
        $this->resetErrorBag();
    }

    public function pastTense($verb = null)
    {
        return preg_replace('/(\w+?)e?\b/', '$1ed', $verb, 1);
    }

    public function camelToSnake($input)
    {
        return strtolower(preg_replace('/(?<!^)[A-Z]/', '_$0', $input));
    }

    public function convertTextFromCamelCase($text, $separator = ' ')
    {
        return preg_replace('/(?<!^)([A-Z])/', $separator . '$1', $text);
    }

    /**
     * Notify Message to  users
     *
     * @param string $status
     * $status = success|failed|error
     *
     * @param string $operation
     * $operation = create|update|delete
     *
     */
    public function notify($status = 'success', $operation = null)
    {
        $operationMode = ($operation != null) ? $operation : ($this->id ? 'update' : 'create');
        session()->flash(
            'notify',
            [
                'status' => $status,
                'operation' => $operationMode
            ]
        );
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

        $numericPart = 50000;

        if ($lastInvoice) {
            $tmpId =  ((int) $numericPart + $lastInvoice->id);
            $lastInvoiceNumber = $lastInvoice->invoice_number;
            $existingNumericPart = intval(substr($lastInvoiceNumber, 3));
            $numericPart = ($tmpId >= $existingNumericPart) ? $tmpId : $existingNumericPart;
        }

        $newInvoiceNumber = $numericPart + 1;
        $newInvoiceNumberFormatted = $invoicePrefix . str_pad($newInvoiceNumber, 5, '0', STR_PAD_LEFT);

        return $newInvoiceNumberFormatted;
    }
}
