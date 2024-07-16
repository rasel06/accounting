<?php

// ---------------------------------------------------------------
// https://laravel-news.com/crud-operations-using-laravel-livewire
// ---------------------------------------------------------------


namespace App\Livewire;

use App\Models\Store;
use Livewire\Component;
use Livewire\WithPagination;
use App\Models\PaymentMethod;
use Livewire\WithFileUploads;
use Livewire\Attributes\Title;
use App\Livewire\Helpers\Modal;
use App\Models\Asset;
use App\Models\AssetType;
use Livewire\WithoutUrlPagination;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use App\Models\Asset as ModelAsset;

class Assets extends Component
{
    use WithPagination, WithoutUrlPagination, WithFileUploads, Modal;

    public  $description, $storeId, $assetTypeId, $accountId, $txnDate,  $amount, $remarks;



    public $accountList = [];
    public $storeList = [];
    public $assetTypeList = [];

    public $paymentMethodFilter = '';

    public $assetFromDate;
    public $assetToDate;



    //  Add store_id

    public $tableFields = [
        'description' => ['Description'],
        'store_id' => ['Store'],
        'asset_type_id' => ['Asset Type'],
        'account_id' => ['Account'],
        'txn_date' => ['Date', 'sortable' => true],
        'amount' => ['Amount', 'sortable' => true],
        'remarks' => ['Remarks']
    ];

    // $description, $storeId, $assetId, $accountId, $txnDate,  $amount, $remarks;

    protected $rules = [
        'description' => 'required',
        'storeId' => 'required',
        'assetTypeId' => 'required',
        'accountId' => 'required',
        'txnDate' => 'required|date',
        'amount' => 'required|numeric',
        'remarks' => 'nullable|string',
    ];

    public function mount()
    {
        $this->sortByColumn = 'txn_date';
        $this->getModule();

        $this->limitFilter = '';

        $this->userId = Auth::id();
        $this->accountList = PaymentMethod::orderBy('name', 'asc')->get();
        if (count($this->accountList) > 0) {
            $this->accountId = $this->accountList[0]->id;
        }

        $this->storeList = Store::with(['location'])->orderBy('name', 'asc')->get();
        if (count($this->storeList) > 0) {
            $this->storeId = $this->storeList[0]->id;
        }

        $this->assetTypeList = AssetType::whereRaw('LOWER(name) != ?', ['cash'])
            ->orderBy('name', 'asc')->get();

        if (count($this->assetTypeList) > 0) {
            $this->assetTypeId = $this->assetTypeList[0]->id;
        }
    }


    private function tableData()
    {
        if ($this->limitFilter != '') {
            return  ModelAsset::with(['assetType', 'store', 'account'])
                ->when($this->nameFilter !== '', function ($query) {
                    return $query->where('description', 'like', '%' . $this->nameFilter . '%');
                })->when($this->paymentMethodFilter !== '', function ($query) {
                    return $query->where('payment_method_id',  $this->paymentMethodFilter);
                })
                ->when($this->assetFromDate != null && $this->assetToDate == null, function ($query) {
                    return $query->where('invoice_date', '>=', $this->assetFromDate);
                })
                ->when($this->assetFromDate != null && $this->assetToDate != null, function ($query) {
                    return $query->whereBetween('invoice_date', [$this->assetFromDate, $this->assetToDate]);
                })
                ->orderBy($this->sortByColumn, $this->sortType)
                ->simplePaginate($this->limitFilter);
        } else {
            return  ModelAsset::with(['assetType', 'store', 'account'])->when($this->nameFilter !== '', function ($query) {
                return $query->where('description', 'like', '%' . $this->nameFilter . '%');
            })
                ->when($this->paymentMethodFilter !== '', function ($query) {
                    return $query->where('payment_method_id',  $this->paymentMethodFilter);
                })
                ->when($this->assetFromDate != null && $this->assetToDate == null, function ($query) {
                    return $query->where('txn_date', '>=', $this->assetFromDate);
                })
                ->when($this->assetFromDate != null && $this->assetToDate != null, function ($query) {
                    return $query->whereBetween('txn_date', [$this->assetFromDate, $this->assetToDate]);
                })
                ->orderBy($this->sortByColumn, $this->sortType)
                ->get();
        }
    }

    #[Title('Assets')]
    public function render()
    {
        return view(
            'livewire.assets',
            [
                "debitTransactionList" => $this->tableData()
            ]
        );
    }

    public function create()
    {
        $this->resetInputFields();
        $this->showModal = true;
    }



    private function resetInputFields()
    {
        if (count($this->accountList) > 0) {
            $this->accountId = $this->accountList[0]->id;
        } else {
            $this->accountId = '';
        }

        if (count($this->storeList) > 0) {
            $this->storeId = $this->storeList[0]->id;
        } else {
            $this->storeId = '';
        }

        if (count($this->assetTypeList) > 0) {
            $this->assetTypeId = $this->assetTypeList[0]->id;
        } else {
            $this->assetTypeId = '';
        }

        $this->description = '';
        $this->txnDate = date('Y-m-d');
        $this->amount = '';
        $this->remarks = '';
        $this->id = null;
    }


    public function store()
    {
        $this->validate();

        try {
            $processedData = [
                'description' => $this->description,
                'store_id' => $this->storeId,
                'asset_type_id' => $this->assetTypeId,
                'account_id' => $this->accountId,
                'txn_date' => $this->txnDate,
                'amount' => $this->amount,
                'remarks' => $this->remarks,
            ];

            if (!$this->id) {
                $processedData['user_id'] = $this->userId;
            }

            ModelAsset::updateOrCreate(['id' => $this->id], $processedData);
            $this->notify();
            $this->showModal = false;
            $this->resetInputFields();
        } catch (\Exception $e) {
            Log::error('Failed to store Asset : ' . $e->getMessage());
            $this->notify('error');
        }
    }

    public function edit($id)
    {
        if ($id) {
            $asset = ModelAsset::findOrFail($id);

            $this->id = $id;
            $this->description = $asset->description;
            $this->storeId = $asset->store_id;
            $this->assetTypeId = $asset->asset_type_id;
            $this->accountId = $asset->account_id;
            $this->txnDate = $asset->txn_date;
            $this->amount = $asset->amount;
            $this->remarks = $asset->remarks;
            $this->showModal = true;
        }
    }


    public function delete($id)
    {
        try {
            $selectedItem = ModelAsset::findOrFail($id);
            $selectedItem->delete();
            $this->notify('success', 'delete');
        } catch (\Exception $e) {
            session()->flash('server_error', $e->getMessage());
            $this->notify('error', 'delete');
            Log::error('Failed to Delete Asset : ' . $e->getMessage());
        }
    }
}
