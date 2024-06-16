<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\PaymentMethod;
use App\Livewire\Helpers\Modal;
use Livewire\WithoutUrlPagination;
use Illuminate\Support\Facades\Auth;
use App\Models\DebitTransaction as ModelsDebitTransaction;

class DebitTransaction extends Component
{

    use WithPagination, WithoutUrlPagination, Modal;

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
    public $payment_method_id = null;     // From List
    public $description = "";
    public $invoice_number = "";
    public $invoice_date = "";
    public $number_of_unit = "";
    public $unit_price = "";
    public $total = "";
    public $remarks = "";


    // --------------------- List From Db ----------------------- >
    public $paymentMethodList = [];




    public function mount()
    {
        $this->userId = Auth::id();
        $this->paymentMethodList =
            PaymentMethod::where('status', 'active')
            ->orderBy('name', 'asc')
            ->get();
        if ($this->paymentMethodList) {
            $this->payment_method_id = $this->paymentMethodList[0]->id;
        }

        PaymentMethod::where('status', 'active')->get();
    }

    public function clean()
    {
        $this->commonClean();
        // $this->name = "";
    }


    public function create($init = null)
    {
        $this->showModal = true;


        if ($init == null) {

            $this->validate([
                'payment_method_id' => ['required'],
                'description' => ['required', 'min:2', 'string', 'max:255'],
                'invoice_number' => ['required'],
                // 'invoice_date' => ['required'],
                'number_of_unit' => ['required', 'decimal:0'],
                'unit_price' => ['required', 'decimal:2'],
                'total' => ['required', 'decimal:2'],
                'remarks' => ['required', 'min:2', 'string', 'max:255'],
            ]);

            if ($this->id) {
                $this->select($this->id);
                $this->selectedItem->update([
                    'payment_method_id' => $this->payment_method_id,
                    'description' => $this->description,
                    'invoice_number' => $this->invoice_number,
                    'invoice_date' => $this->invoice_date,
                    'number_of_unit' => $this->number_of_unit,
                    'unit_price' => $this->unit_price,
                    'total' => $this->total,
                    'user_id' => $this->userId,
                    'remarks' => $this->remarks
                ]);
                $this->showModal = false;
                $this->clean();
            } else {

                $pay_method = ModelsDebitTransaction::create([
                    'payment_method_id' => $this->payment_method_id,
                    'description' => $this->description,
                    'invoice_number' => $this->invoice_number,
                    'invoice_date' => $this->invoice_date,
                    'number_of_unit' => $this->number_of_unit,
                    'unit_price' => $this->unit_price,
                    'total' => $this->total,
                    'user_id' => $this->userId,
                    'remarks' => $this->remarks
                ]);
                if ($pay_method->id > 0) {
                    $this->showModal = false;
                    $this->clean();
                }
            }
        }
    }

    public function edit($id = null)
    {
        $this->id = $id;

        if ($id) {
            $this->select($id);
            $this->payment_method_id = $this->selectedItem->payment_method_id;
            $this->description = $this->selectedItem->description;
            $this->invoice_number = $this->selectedItem->invoice_number;
            $this->invoice_date = $this->selectedItem->invoice_date;
            $this->number_of_unit = $this->selectedItem->number_of_unit;
            $this->unit_price = $this->selectedItem->unit_price;
            $this->total = $this->selectedItem->total;
            $this->userId = $this->selectedItem->user_id;
            $this->remarks = $this->selectedItem->remarks;
        }

        $this->showModal = true;
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
        $this->selectedItem = ModelsDebitTransaction::find($id);;
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

        //dd($this->tableData());
        return view('livewire.debit-transaction', [
            "debitTransactionList" => $this->tableData()
        ]);
    }
}
