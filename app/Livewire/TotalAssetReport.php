<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\Attributes\Title;
use App\Livewire\Helpers\Modal;
use App\Models\DebitTransaction;

class TotalAssetReport extends Component
{

    use Modal;

    public $reportFromDate, $reportToDate;
    public $reportData = [];

    public function loadReportData()
    {
        $this->reportData['debit_transactions'] =    DebitTransaction::get();
        // print_r($reportData['debitTransaction']);
    }

    public function mount()
    {
        //$this->reportFromDate = $this->reportToDate = date('Y-m-d');
        // $this->reportData = [];
    }

    public function clearReport()
    {
        $this->reportFromDate = $this->reportToDate = date('Y-m-d');
        $this->reportData = [];
    }


    #[Title('Total Asset Report')]
    public function render()
    {
        return view(
            'livewire.total-asset-report',
            [
                "reportData" => $this->reportData
            ]
        );
    }
}
