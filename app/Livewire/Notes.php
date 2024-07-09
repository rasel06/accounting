<?php

namespace App\Livewire;

use App\Models\Store;
use Livewire\Component;
use App\Models\AssetType;
use Livewire\WithPagination;
use App\Models\PaymentMethod;
use Livewire\Attributes\Title;
use App\Livewire\Helpers\Modal;
use App\Models\Note as ModelNote;
use Livewire\WithoutUrlPagination;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;


class Notes extends Component
{

    // ['title', 'user_id',  'store_id', 'account_id', 'is_important', 'note_date', 'details', 'remarks'];

    use WithPagination, WithoutUrlPagination, Modal;

    public  $description, $storeId, $assetTypeId, $accountId, $txnDate,  $amount, $remarks;



    public $accountList = [];
    public $storeList = [];
    public $assetTypeList = [];

    public $paymentMethodFilter = '';



    //  Add store_id


    // ['title', 'user_id',  'store_id', 'account_id', 'is_important', 'note_date', 'details', 'remarks'];

    public $tableFields = [
        'title' => ['title'],
        'store_id' => ['Store'],
        'account_id' => ['Account'],
        'is_important' => ['Is Important'],
        'note_date' => ['Date'],
        'details' => ['Details'],
        'remarks' => ['Remarks']
    ];

    // $description, $storeId, $assetId, $accountId, $txnDate,  $amount, $remarks;

    protected $rules = [
        'title' => 'required',
        'storeId' => '',
        'accountId' => '',
        'isImportant' => 'required',
        'noteDate' => 'required|date',
        'details' => 'details',
        'remarks' => 'nullable|string',
    ];

    public function mount()
    {
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
            return  ModelNote::with(['assetType', 'store', 'account'])
                ->when($this->nameFilter !== '', function ($query) {
                    return $query->where('description', 'like', '%' . $this->nameFilter . '%');
                })->when($this->paymentMethodFilter !== '', function ($query) {
                    return $query->where('payment_method_id',  $this->paymentMethodFilter);
                })->orderBy('created_at', 'desc')
                ->simplePaginate($this->limitFilter);
        } else {
            return  ModelNote::with(['assetType', 'store', 'account'])->when($this->nameFilter !== '', function ($query) {
                return $query->where('description', 'like', '%' . $this->nameFilter . '%');
                // ->orWhere('invoice_number', 'like', '%' . $this->nameFilter . '%')
                // ->orWhere('remarks', 'like', '%' . $this->nameFilter . '%');
            })
                ->when($this->paymentMethodFilter !== '', function ($query) {
                    return $query->where('payment_method_id',  $this->paymentMethodFilter);
                })->orderBy('created_at', 'desc')->get();
        }
    }

    #[Title('Assets')]
    public function render()
    {
        return view(
            'livewire.notes',
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
            $this->storeId = '';
        }

        $this->description = '';
        $this->txnDate = date('Y-m-d');
        $this->amount = '';
        $this->remarks = '';
        $this->id = null;
    }


    public function store()
    {
        // if ($this->id) {
        //     $this->rules['description'] = ['required', 'unique:assets,description,' . $this->id];
        // }

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

            ModelNote::updateOrCreate(['id' => $this->id], $processedData);
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
            $asset = ModelNote::findOrFail($id);

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
            $selectedItem = ModelNote::findOrFail($id);

            $this->selectedId = $selectedItem->invoice_number;

            if (isset($selectedItem->invoice_file) && $selectedItem->invoice_file != "") {
                $filePath = public_path('storage/' . $selectedItem->invoice_file);
                if (file_exists($filePath)) {
                    unlink($filePath);
                }
            }
            $selectedItem->delete();
            $this->notify('success', 'delete');
        } catch (\Exception $e) {
            session()->flash('server_error', $e->getMessage());
            $this->notify('error', 'delete');
            Log::error('Failed to Delete Asset : ' . $e->getMessage());
        }
    }
}
