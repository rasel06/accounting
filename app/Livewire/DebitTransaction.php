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
    // use WithFileUploads, Modal;;

    use WithPagination, WithoutUrlPagination, WithFileUploads, Modal;

    public $paymentMethodId, $description, $invoiceNumber, $invoiceFile, $invoiceDate, $numberOfUnit, $unitPrice, $total, $remarks;
    public $transactionId;


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
        // 'paymentMethodId' => 'required|string',
        // 'description' => 'required|string',
        // 'invoiceNumber' => 'required|integer',
        // 'invoiceFile' => 'nullable|file|max:1024',
        // 'invoiceDate' => 'required|date',
        // 'numberOfUnit' => 'required|integer',
        // 'unitPrice' => 'required|numeric',
        // 'total' => 'required|numeric',
        // 'remarks' => 'nullable|string',


        'paymentMethodId' => ['required'],
        'description' => ['required', 'min:2', 'string', 'max:255'],
        'invoiceNumber' => ['required'],
        'invoiceDate' => ['required'],
        'numberOfUnit' => ['required', 'numeric'],
        'unitPrice' => ['required', 'numeric'],
        'total' => ['required', 'numeric'],
        'remarks' => ['required', 'min:2', 'string', 'max:255'],

    ];

    public $paymentMethodList = [];

    public function mount()
    {
        $this->userId = Auth::id();
        $this->paymentMethodList = PaymentMethod::orderBy('name', 'asc')->get();
        if ($this->paymentMethodList) {
            $this->paymentMethodId = $this->paymentMethodList[0]->id;
        }
    }


    protected function tableData()
    {
        if ($this->limitFilter != '') {
            return  ModelDebitTransaction::with(['paymentMethod'])->when($this->nameFilter !== '', function ($query) {
                return $query->where('description', 'like', '%' . $this->nameFilter . '%');
            })
                ->orderBy('created_at', 'desc')
                ->simplePaginate($this->limitFilter);
        } else {
            return  ModelDebitTransaction::with(['paymentMethod'])->when($this->nameFilter !== '', function ($query) {
                return $query->where('description', 'like', '%' . $this->nameFilter . '%');
            })->orderBy('created_at', 'desc')->get();
        }
    }
    public function render()
    {
        return view('livewire.debit-transaction',  ["debitTransactionList" => $this->tableData()]);
    }

    public function create()
    {
        $this->resetInputFields();
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
        $this->reset(['paymentMethodId', 'description', 'invoiceNumber', 'invoiceFile', 'invoiceDate', 'numberOfUnit', 'unitPrice', 'total', 'remarks', 'transactionId']);
    }

    public function store()
    {
        $this->validate();

        $data = [
            'payment_method_id' => $this->paymentMethodId,
            'description' => $this->description,
            'invoice_number' => $this->invoiceNumber,
            'invoice_date' => $this->invoiceDate,
            'number_of_unit' => $this->numberOfUnit,
            'unit_price' => $this->unitPrice,
            'total' => $this->total,
            'remarks' => $this->remarks,
        ];

        if ($this->invoiceFile) {
            $data['invoice_file'] = $this->invoiceFile->store('invoices');
        }

        DebitTransaction::updateOrCreate(['id' => $this->transactionId], $data);

        session()->flash('message', $this->transactionId ? 'Transaction Updated Successfully.' : 'Transaction Created Successfully.');

        $this->closeModal();
        $this->resetInputFields();
    }

    public function edit($id)
    {
        $transaction = DebitTransaction::findOrFail($id);
        $this->transactionId = $id;
        $this->fill($transaction->toArray());
        $this->openModal();
    }

    public function delete($id)
    {
        DebitTransaction::find($id)->delete();
        session()->flash('message', 'Transaction Deleted Successfully.');
    }
}


//  #[Title('Debit Transaction')]
//     public function render()
//     {
//         return view('livewire.debit-transaction',  ["debitTransactionList" => $this->tableData()]);
//     }
