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
use App\Models\DebitTransaction as ModelsDebitTransaction;

class DebitTransaction extends Component
{

    use WithPagination, WithoutUrlPagination, WithFileUploads, Modal;

    public $title = "Debit Transaction";

    public $tableFields = [
        'payment_method_id' => 'Payment Method',
        //  'description' => 'Description',
        'invoice_number' => 'Invoice Number',
        'number_of_unit' => 'Number of Unit',
        'unit_price' => 'Unit Price',
        'total' => 'Total',
        // 'remarks' => 'Remarks'
    ];



    // ----------------------  DB Attributes --------------------- >
    public $paymentMethodId, $description, $invoiceNumber, $invoiceDate, $invoiceFile, $numberOfUnit, $unitPrice, $total, $remarks;


    // --------------------- List From Db ----------------------- >
    public $paymentMethodList = [];

    protected $listeners = ['numberOfUnit' => 'numberOfUnitChange'];

    protected function numberOfUnitChange()
    {
        dd($this->numberOfUnit);
    }



    public function mount()
    {
        $this->userId = Auth::id();
        $this->paymentMethodList = PaymentMethod::orderBy('name', 'asc')->get();
        if ($this->paymentMethodList) {
            $this->paymentMethodId = $this->paymentMethodList[0]->id;
        }
    }

    public function clean()
    {
        $this->commonClean();
        $this->paymentMethodId = $this->paymentMethodList[0]->id;
        $this->description = "";
        $this->invoiceNumber = "";
        $this->invoiceFile = "";
        $this->invoiceDate = "";
        $this->numberOfUnit = "";
        $this->unitPrice = "";
        $this->total = "";
        $this->remarks = "";
    }

    public $validationState = false;

    public function create($init = null)
    {
        $this->showModal = true;

        if ($init == null) {

            //if ($this->validationState) {
            $this->validate([
                'paymentMethodId' => ['required'],
                'description' => ['required', 'min:2', 'string', 'max:255'],
                'invoiceNumber' => ['required'],
                'invoiceDate' => ['required'],
                'numberOfUnit' => ['required', 'numeric'],
                'unitPrice' => ['required', 'numeric'],
                'total' => ['required', 'numeric'],
                'remarks' => ['required', 'min:2', 'string', 'max:255'],
            ]);
            //}

            if ($this->id) {
                $this->select($this->id);
                $this->selectedItem->update([
                    'payment_method_id' => $this->paymentMethodId,
                    'description' => $this->description,
                    'invoice_number' => $this->invoiceNumber,
                    'invoice_date' => $this->invoiceDate,
                    'number_of_unit' => $this->numberOfUnit,
                    'unit_price' => $this->unitPrice,
                    'total' => $this->total,
                    'user_id' => $this->userId,
                    'remarks' => $this->remarks
                ]);
                $this->showModal = false;
            } else {

                $newEntry = ModelsDebitTransaction::create([
                    'payment_method_id' => $this->paymentMethodId,
                    'description' => $this->description,
                    'invoice_number' => $this->invoiceNumber,
                    'invoice_date' => $this->invoiceDate,
                    'number_of_unit' => $this->numberOfUnit,
                    'unit_price' => $this->unitPrice,
                    'total' => $this->total,
                    'user_id' => $this->userId,
                    'remarks' => $this->remarks,
                    'invoice_file' => $this->invoice_number
                ]);

                if ($newEntry->id > 0) {
                    $this->invoice_file->storeAs(path: '/invoices', name: $newEntry->invoice_number);
                    $this->showModal = false;
                }
            }
            $this->clean();
        }
    }

    public function edit($id = null)
    {

        if ($id) {
            $this->id = $id;
            $this->select($id);
            $this->paymentMethodId = $this->selectedItem->payment_method_id;
            $this->description = $this->selectedItem->description;
            $this->invoiceNumber = $this->selectedItem->invoice_number;
            $this->invoiceDate = $this->selectedItem->invoice_date;
            $this->numberOfUnit = $this->selectedItem->number_of_unit;
            $this->unitPrice = $this->selectedItem->unit_price;
            $this->total = $this->selectedItem->total;
            $this->userId = $this->selectedItem->user_id;
            $this->remarks = $this->selectedItem->remarks;

            $this->showModal = true;
        }
    }

    public function delete($id = null)
    {
        if ($id) {
            $this->select($id);
            $this->selectedItem->delete();
        }
    }

    protected function select($id)
    {
        $this->selectedItem = ModelsDebitTransaction::find($id);
    }


    protected function tableData()
    {
        if ($this->limitFilter != '') {
            return  ModelsDebitTransaction::with(['paymentMethod'])->when($this->nameFilter !== '', function ($query) {
                return $query->where('description', 'like', '%' . $this->nameFilter . '%');
            })
                ->orderBy('created_at', 'desc')
                ->simplePaginate($this->limitFilter);
        } else {
            return  ModelsDebitTransaction::with(['paymentMethod'])->when($this->nameFilter !== '', function ($query) {
                return $query->where('description', 'like', '%' . $this->nameFilter . '%');
            })->orderBy('created_at', 'desc')->get();
        }
    }

    public function render()
    {
        return view('livewire.debit-transaction', [
            "debitTransactionList" => $this->tableData()
        ]);
    }
}
