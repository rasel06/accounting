<?php

// ---------------------------------------------------------------
// https://laravel-news.com/crud-operations-using-laravel-livewire
// ---------------------------------------------------------------


namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\PaymentMethod;
use Livewire\WithFileUploads;
use App\Livewire\Helpers\Modal;
use Livewire\WithoutUrlPagination;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use App\Models\DebitTransaction as ModelDebitTransaction;
use App\Models\Store;

class DebitTransaction extends Component
{
    use WithPagination, WithoutUrlPagination, WithFileUploads, Modal;

    public $storeId, $paymentMethodId, $description, $invoiceNumber, $invoiceFile, $invoiceDate, $numberOfUnit, $unitPrice, $total, $remarks;
    public $paymentMethodList = [];
    public $storeList = [];

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

    protected $rules = [
        // 'storeId' => 'required',
        'paymentMethodId' => 'required',
        'description' => 'required',
        'invoiceNumber' => ['required', 'regex:/^DBD5\d{5}$/', 'unique:debit_transactions,invoice_number'],
        'invoiceDate' => 'required|date',
        'numberOfUnit' => 'required|integer',
        'unitPrice' => 'required|numeric',
        'total' => 'required|numeric',
        'remarks' => 'nullable|string',
    ];

    public function mount()
    {
        $this->getModule();
        $this->userId = Auth::id();
        $this->paymentMethodList = PaymentMethod::orderBy('name', 'asc')->get();
        if ($this->paymentMethodList) {
            $this->paymentMethodId = $this->paymentMethodList[0]->id;
        }

        $this->storeList = Store::with(['location'])->orderBy('name', 'asc')->get();
        if ($this->storeList) {
            $this->storeId = $this->storeList[0]->id;
        }
    }


    private function tableData()
    {
        if ($this->limitFilter != '') {
            return  ModelDebitTransaction::with(['paymentMethod', 'store'])
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

    public function render()
    {
        return view(
            'livewire.debit-transaction',
            [
                "debitTransactionList" => $this->tableData()
            ]
        );
    }

    public function create()
    {
        $this->resetInputFields();
        $this->invoiceNumber = $this->generateNextInvoiceNumber('debit');
        $this->showModal = true;
    }



    private function resetInputFields()
    {
        if ($this->paymentMethodList) {
            $this->paymentMethodId = $this->paymentMethodList[0]->id;
        } else {
            $this->paymentMethodId = '';
        }

        if ($this->storeList) {
            $this->storeId = $this->storeList[0]->id;
        } else {
            $this->storeId = '';
        }

        $this->description = '';
        $this->invoiceNumber = '';
        $this->invoiceFile = '';
        $this->invoiceDate = '';
        $this->numberOfUnit = '';
        $this->unitPrice = '';
        $this->total = '';
        $this->remarks = '';
        $this->id = null;
    }

    public function reGenerate($type = 1)
    {
        if ($type == 1) {
            $this->invoiceNumber = $this->generateNextInvoiceNumber('debit');
        }
    }

    public function updated($field)
    {
        if ($field === 'numberOfUnit' || $field === 'unitPrice' || $field === 'total') {
            $this->calculateTotal();
        }
    }

    private function calculateTotal()
    {
        $numberOfUnit = (int) $this->numberOfUnit;
        $unitPrice = (float) $this->unitPrice;
        $this->total = number_format($numberOfUnit * $unitPrice, 2, '.', '');
    }

    public function store()
    {
        if ($this->id) {
            $this->rules['invoiceNumber'] = ['required', 'regex:/^DBD5\d{5}$/', 'unique:debit_transactions,invoice_number,' . $this->id];
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
                'payment_method_id' => $this->paymentMethodId,
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
            $this->paymentMethodId = $transaction->payment_method_id;
            $this->description = $transaction->description;
            $this->invoiceNumber = $transaction->invoice_number;
            $this->invoiceFile = $transaction->invoice_file;
            $this->invoiceDate = $transaction->invoice_date;
            $this->numberOfUnit = $transaction->number_of_unit;
            $this->unitPrice = $transaction->unit_price;
            $this->total = $transaction->total;
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
            Log::error('Failed to Delete Debit transaction: ' . $e->getMessage());
            $this->notify('error', 'delete');
        }
    }
}
