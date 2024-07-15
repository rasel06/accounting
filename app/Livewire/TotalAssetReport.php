<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Carbon;
use Livewire\Attributes\Title;
use App\Livewire\Helpers\Modal;
use App\Models\CreditTransaction;
use App\Models\DebitTransaction;
use Illuminate\Support\Facades\DB;

class TotalAssetReport extends Component
{

    use Modal;

    public $reportFromDate, $reportToDate;
    public $reportData = [];

    public function loadReportData()
    {
        $this->reportData['totalDebit'] = DB::table('debit_transactions')
            ->whereBetween('invoice_date', [$this->reportFromDate, $this->reportToDate])
            ->sum('total');

        $this->reportData['totalCredit'] = DB::table('credit_transactions')
            ->whereBetween('invoice_date', [$this->reportFromDate, $this->reportToDate])
            ->sum('amount');

        $this->reportData['othersData'] = DB::table('assets')
            ->selectRaw('sum(amount) as amount,  asset_types.name')
            ->join('asset_types', 'assets.asset_type_id', '=', 'asset_types.id')
            ->groupBy('assets.asset_type_id', 'asset_types.name')
            ->whereBetween('txn_date', [$this->reportFromDate, $this->reportToDate])
            ->orderBy('asset_types.name')
            ->get();

        // dd($this->reportData);

        // $this->reportData['debit_transactions'] =    DebitTransaction::whereBetween('invoice_date', [$this->reportFromDate, $this->reportToDate])->get();
        // $this->reportData['credit_transactions'] =    CreditTransaction::whereBetween('invoice_date', [$this->reportFromDate, $this->reportToDate])->get();
    }

    public function mount()
    {
        $this->reportFromDate = $this->reportToDate = date('Y-m-d');
        $this->reportData['totalDebit'] = 0;
        $this->reportData['totalCredit'] = 0;
        $this->reportData['othersData'] = [];
    }

    public function clearReport()
    {
        $this->reportFromDate = $this->reportToDate = date('Y-m-d');
        $this->reportData['totalDebit'] = 0;
        $this->reportData['totalCredit'] = 0;
        $this->reportData['othersData'] = [];
    }


    #[Title('Total Asset Report')]
    public function render()
    {
        // if (isset($this->reportData['debit_transactions'])) {
        //     print_r($this->reportData['debit_transactions']);
        // }

        return view(
            'livewire.total-asset-report',
            [
                "reportData" => $this->reportData,
            ]
        );
    }
}
