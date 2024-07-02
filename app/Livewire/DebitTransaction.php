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
use Illuminate\Support\Facades\Auth;
use App\Models\DebitTransaction as ModelDebitTransaction;


class DebitTransaction extends Component
{
    use WithPagination, WithoutUrlPagination, WithFileUploads, Modal;

    public $paymentMethodId, $description, $invoiceNumber, $invoiceFile, $invoiceDate, $numberOfUnit, $unitPrice, $total, $remarks;
    public $paymentMethodList = [];
    public $showModal = false;

    public $creditAccountFilter = '';

    public $tableFields = [
        'credit_account_id' => 'Payment Method',
        'description' => 'Description',
        'invoice_number' => 'Invoice Number',
        'invoice_date' => 'Invoice Date',
        'invoice_file' => 'Invoice Upload',
        'number_of_unit' => 'Unit',
        'unit_price' => 'Unit Price',
        'total' => 'Total',
        'remarks' => 'Remarks'
    ];

    protected $rules = [
        'paymentMethodId' => 'required',
        'description' => 'required',
        'invoiceNumber' => ['required', 'regex:/^DBD5\d{5}$/', 'unique:debit_transactions,invoice_number'],
        // 'invoiceNumber' => 'required|integer',
        // 'invoiceFile' => 'required|file|max:1024', // Adjust size limit as needed
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
    }


    private function tableData()
    {
        if ($this->limitFilter != '') {
            return  ModelDebitTransaction::with(['paymentMethod'])
                ->when($this->nameFilter !== '', function ($query) {
                    return $query->where('description', 'like', '%' . $this->nameFilter . '%')
                        ->orWhere('invoice_number', 'like', '%' . $this->nameFilter . '%')
                        ->orWhere('remarks', 'like', '%' . $this->nameFilter . '%');
                })->when($this->creditAccountFilter !== '', function ($query) {
                    return $query->where('payment_method_id',  $this->creditAccountFilter);
                })->orderBy('created_at', 'desc')
                ->simplePaginate($this->limitFilter);
        } else {
            return  ModelDebitTransaction::with(['paymentMethod'])->when($this->nameFilter !== '', function ($query) {
                return $query->where('description', 'like', '%' . $this->nameFilter . '%')
                    ->orWhere('invoice_number', 'like', '%' . $this->nameFilter . '%')
                    ->orWhere('remarks', 'like', '%' . $this->nameFilter . '%');
            })
                ->when($this->creditAccountFilter !== '', function ($query) {
                    return $query->where('payment_method_id',  $this->creditAccountFilter);
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
        $this->openModal();
    }

    public function openModal()
    {
        $this->showModal = true;
    }

    public function closeModal()
    {
        $this->showModal = false;
    }

    private function resetInputFields()
    {
        if ($this->paymentMethodList) {
            $this->paymentMethodId = $this->paymentMethodList[0]->id;
        } else {
            $this->paymentMethodId = '';
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
        if ($this->id) {
            if ($type == 1) {
                $this->invoiceNumber = $this->generateNextInvoiceNumber('debit');
            }
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
        $numberOfUnit = (float) $this->numberOfUnit;
        $unitPrice = (float) $this->unitPrice;
        $this->total = $numberOfUnit * $unitPrice;
    }

    public function hydrate()
    {
        // $this->dispatch('myEventName', ['total' => $this->total]);
        $this->dispatch('myEventName', $this->total);
    }


    public function store()
    {
        if ($this->id) {
            $this->rules['invoiceNumber'] = ['required', 'regex:/^DBD5\d{5}$/', 'unique:debit_transactions,invoice_number,' . $this->id];
        }

        $this->validate();

        $filePath = "";
        if (gettype($this->invoiceFile) !== 'string' && $this->invoiceFile) {

            $uploadedFileName = $this->invoiceNumber . '.' .
                $this->invoiceFile->guessExtension();
            $filePath = $this->invoiceFile->storeAs(path: '/invoices', name: $uploadedFileName);
        }

        $processedData = [
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

        // session()->flash(
        //     'message',
        //     $this->id ? 'Transaction Updated Successfully.' : 'Transaction Created Successfully.'
        // );

        session()->flash(
            'message',
            [
                'success' => true,
                'mode' => $this->id ? 'Update' : 'Create',

            ]
            // $this->id ? 'Transaction Updated Successfully.' : 'Transaction Created Successfully.'
        );


        $this->closeModal();
        $this->resetInputFields();
    }

    public function edit($id)
    {
        $transaction = ModelDebitTransaction::findOrFail($id);
        $this->id = $id;
        $this->paymentMethodId = $transaction->payment_method_id;
        $this->description = $transaction->description;
        $this->invoiceNumber = $transaction->invoice_number;
        $this->invoiceFile = $transaction->invoice_file;
        $this->invoiceDate = $transaction->invoice_date;
        $this->numberOfUnit = $transaction->number_of_unit;
        $this->unitPrice = $transaction->unit_price;
        $this->total = $transaction->total;
        $this->remarks = $transaction->remarks;

        $this->openModal();
    }

    public function delete($id)
    {
        $selectedItem = ModelDebitTransaction::findOrFail($id);
        $filePath = public_path('storage/' . $selectedItem->invoice_file);
        if (file_exists($filePath)) {
            unlink($filePath);
        }
        $selectedItem->delete();
        session()->flash('message', 'Transaction Deleted Successfully.');
    }
}
