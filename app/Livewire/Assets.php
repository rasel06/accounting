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
use App\Models\DebitTransaction as ModelDebitTransaction;

class Assets extends Component
{
    use WithPagination, WithoutUrlPagination, WithFileUploads, Modal;

    public  $description, $storeId, $assetTypeId, $accountId, $txnDate,  $amount, $remarks;



    public $accountList = [];
    public $storeList = [];
    public $assetTypeList = [];

    public $paymentMethodFilter = '';

    //  Add store_id

    public $tableFields = [
        'store_id' => ['Store'],
        'payment_method_id' => ['Payment Method'],
        'description' => ['Description'],
        'invoice_number' => ['Invoice Number'],
        'invoice_date' => ['Invoice Date'],
        'invoice_file' => ['Invoice Upload', 'w-10 '],
        'number_of_unit' => ['Unit'],
        'unit_price' => ['Unit Price'],
        'total' => ['Total'],
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
        $this->getModule();
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
            return  ModelDebitTransaction::with(['paymentMethod', 'store', 'store.location'])
                ->when($this->nameFilter !== '', function ($query) {
                    return $query->where('description', 'like', '%' . $this->nameFilter . '%')
                        ->orWhere('invoice_number', 'like', '%' . $this->nameFilter . '%')
                        ->orWhere('remarks', 'like', '%' . $this->nameFilter . '%');
                })->when($this->paymentMethodFilter !== '', function ($query) {
                    return $query->where('payment_method_id',  $this->paymentMethodFilter);
                })->orderBy('created_at', 'desc')
                ->simplePaginate($this->limitFilter);
        } else {
            return  ModelDebitTransaction::with(['paymentMethod', 'store'])->when($this->nameFilter !== '', function ($query) {
                return $query->where('description', 'like', '%' . $this->nameFilter . '%')
                    ->orWhere('invoice_number', 'like', '%' . $this->nameFilter . '%')
                    ->orWhere('remarks', 'like', '%' . $this->nameFilter . '%');
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
            $this->storeId = '';
        }

        $this->description = '';
        // $this->invoiceNumber = '';
        // $this->invoiceFile = '';
        // $this->invoiceDate = '';
        // $this->numberOfUnit = '';
        // $this->unitPrice = '';
        // $this->total = '';
        $this->remarks = '';
        $this->id = null;
    }


    public function store()
    {
        if ($this->id) {
            $this->rules['invoiceNumber'] = ['required', 'regex:/^DBD5\d{4}$/', 'unique:debit_transactions,invoice_number,' . $this->id];
        }

        if (gettype($this->invoiceFile) !== 'string' && $this->invoiceFile) {
            $this->rules['invoiceFile'] = 'required|max:1024';
        }

        $this->validate();

        try {

            $filePath = "";
            if (gettype($this->invoiceFile) !== 'string' && $this->invoiceFile) {
                $uploadedFileName = $this->invoiceNumber . '.' . $this->invoiceFile->guessExtension();
                $filePath = $this->invoiceFile->storeAs('/invoices/debit', $uploadedFileName);
            }

            $processedData = [
                'store_id' => $this->storeId,
                'payment_method_id' => $this->accountId,
                'description' => $this->description,
                'invoice_number' => $this->invoiceNumber,
                'invoice_file' => $filePath,
                'invoice_date' => $this->invoiceDate,
                'number_of_unit' => $this->numberOfUnit,
                'unit_price' => $this->unitPrice,
                'total' => $this->total,
                'remarks' => $this->remarks,
            ];

            if ($this->id && gettype($this->invoiceFile) === 'string') {
                unset($processedData['invoice_file']);
            }

            if (!$this->id) {
                $processedData['user_id'] = $this->userId;
            }

            ModelDebitTransaction::updateOrCreate(['id' => $this->id], $processedData);
            $this->notify();
            $this->showModal = false;
            $this->resetInputFields();
        } catch (\Exception $e) {
            Log::error('Failed to store debit transaction: ' . $e->getMessage());
            $this->notify('error');
        }
    }

    public function edit($id)
    {
        if ($id) {
            $transaction = ModelDebitTransaction::findOrFail($id);

            $this->selectedId = $transaction->invoice_number;

            $this->id = $id;
            $this->storeId = $transaction->store_id;
            $this->accountId = $transaction->accountId;
            $this->description = $transaction->description;
            // $this->invoiceNumber = $transaction->invoice_number;
            // $this->invoiceFile = $transaction->invoice_file;
            // $this->invoiceDate = $transaction->invoice_date;
            // $this->numberOfUnit = $transaction->number_of_unit;
            // $this->unitPrice = $transaction->unit_price;
            // $this->total = $transaction->total;
            $this->remarks = $transaction->remarks;

            $this->showModal = true;
        }
    }


    public function delete($id)
    {
        try {
            $selectedItem = ModelDebitTransaction::findOrFail($id);

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
            Log::error('Failed to Delete Debit transaction: ' . $e->getMessage());
        }
    }
}
