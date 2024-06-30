<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\PaymentMethod;
use Livewire\WithFileUploads;
use Livewire\Attributes\Title;
use App\Livewire\Helpers\Modal;
use Illuminate\Validation\Rule;
use Livewire\WithoutUrlPagination;
use Illuminate\Support\Facades\Auth;
use App\Models\CreditTransaction as ModelCreditTransaction;

class CreditTransaction extends Component
{
    use WithPagination, WithoutUrlPagination, WithFileUploads, Modal;

    public $title = "Credit Transaction";

    public $tableFields = [
        'credit_account_id' => 'Credit Account',
        'description' => 'Description',
        'invoice_number' => 'Invoice Number',
        'invoice_date' => 'Invoice Date',
        'invoice_file' => 'Invoice Upload',
        'amount' => 'Total',
        // 'unit_price' => 'Unit Price',
        // 'total' => 'Total',
        'remarks' => 'Remarks',
        // 'invoice_file' => 'Invoice File',
    ];

    // ----------------------  DB Attributes --------------------- >
    public $creditAccountId;
    public $description;
    public $invoiceNumber;
    public $invoiceDate;
    public $invoiceFile;
    public $amount;
    public $remarks;

    public $existingInvoiceFile;

    public $creditAccountList = [];
    public $creditAccountFilter = "";

    protected $listeners = [
        'deletePostListener' => 'deletePost'
    ];

    public function updated($propertyName)
    {
        if ($propertyName === 'invoiceNumber') {
            $this->invoiceNumber = strtoupper($this->invoiceNumber);
        }
    }

    protected $validationRules = [
        'creditAccountId' => ['required'],
        'description' => ['required', 'min:2', 'string', 'max:255'],
        'invoiceNumber' => ['required', 'regex:/^DBC5\d{5}$/', 'unique:credit_transactions,invoice_number'],
        'invoiceDate' => ['required'],
        'amount' => ['required', 'numeric'],
        'remarks' => ['required', 'min:2', 'string', 'max:255'],
    ];

    public function resetFields()
    {
        $this->commonReset();
        $this->creditAccountId = $this->creditAccountList[0]->id;
        $this->description = "";
        $this->invoiceNumber = "";
        $this->invoiceFile = "";
        $this->invoiceDate = "";
        $this->amount = "";
        $this->remarks = "";

        $this->existingInvoiceFile = "";
    }



    public function create()
    {
        $this->resetFields();
        $this->operationMode();
        $this->invoiceNumber = $this->generateNextInvoiceNumber();
    }

    public function reGenerate($type = 1)
    {
        if ($this->addMode == true) {
            if ($type == 1) {
                $this->invoiceNumber = $this->generateNextInvoiceNumber();
            }
        }
    }

    public function store()
    {
        $this->validate($this->validationRules);
        try {
            $invoiceFilePath = "";
            if ($this->invoiceFile) {
                $uploadedFileName = $this->invoiceNumber . '.' .
                    $this->invoiceFile->guessExtension();
                $invoiceFilePath = $this->invoiceFile->storeAs(path: '/invoices', name: $uploadedFileName);
            }

            $newEntry = ModelCreditTransaction::create([
                'credit_account_id' => $this->creditAccountId,
                'description' => $this->description,
                'invoice_number' => $this->invoiceNumber,
                'invoice_date' => $this->invoiceDate,
                'amount' => $this->amount,
                'user_id' => $this->userId,
                'remarks' => $this->remarks,
                'invoice_file' => $invoiceFilePath
            ]);


            if ($newEntry->id > 0) {
                $this->showModal = false;
            }
            session()->flash('success', 'Transaction Added Successfully!!');
            $this->resetFields();
            $this->addMode = false;
        } catch (\Exception $ex) {
            session()->flash('error', 'Something goes wrong!!');
        }
    }

    protected function operationMode($create = true)
    {
        $this->addMode = $create ? true : false;
        $this->editMode = !$create ? true : false;
        $this->showModal = true;
        if (!$create) {
            $this->select();
        }
    }

    protected function select()
    {
        $this->selectedItem = ModelCreditTransaction::find($this->id);
    }

    public function edit($id = null)
    {
        if ($id) {
            $this->id = $id;
            $this->operationMode(false);
            $this->creditAccountId = $this->selectedItem->credit_account_id;
            $this->description = $this->selectedItem->description;
            $this->invoiceNumber = $this->selectedItem->invoice_number;
            $this->invoiceFile =  $this->selectedItem->invoice_file;
            $this->invoiceDate = $this->selectedItem->invoice_date;
            $this->amount = $this->selectedItem->amount;
            $this->remarks = $this->selectedItem->remarks;
        }
    }

    public function delete($id = null)
    {
        if ($id) {
            $this->select($id);
            $this->selectedItem->delete();
        }
    }

    public function update()
    {
        $this->validate($this->validationRules);

        try {
            $invoiceFilePath = "";

            if ($this->invoiceFile) {
                $uploadedFileName = $this->invoiceNumber . '.' .
                    $this->invoiceFile->guessExtension();
                $invoiceFilePath = $this->invoiceFile->storeAs(path: '/invoices', name: $uploadedFileName);
            }

            $updateData = [
                'credit_account_id' => $this->creditAccountId,
                'description' => $this->description,
                'invoice_number' => $this->invoiceNumber,
                'invoice_date' => $this->invoiceDate,
                'amount' => $this->amount,
                'user_id' => $this->userId,
                'remarks' => $this->remarks,

            ];

            if ($invoiceFilePath != "") {
                $updateData = ['invoice_file' => $invoiceFilePath];
            }

            $updateEntry =  $this->selectedItem->update($updateData);

            if ($updateEntry == 1) {
                $this->showModal = false;
            }

            $this->resetFields();
            $this->addMode = false;
        } catch (\Exception $ex) {
            session()->flash('error', 'Something goes wrong!!');
        }
    }


    protected function tableData()
    {
        if ($this->limitFilter != '') {
            return  ModelCreditTransaction::with(['creditAccount'])
                ->when($this->nameFilter !== '', function ($query) {
                    return $query->where('description', 'like', '%' . $this->nameFilter . '%')
                        ->orWhere('invoice_number', 'like', '%' . $this->nameFilter . '%')
                        ->orWhere('remarks', 'like', '%' . $this->nameFilter . '%');
                })->when($this->creditAccountFilter !== '', function ($query) {
                    return $query->where('credit_account_id',  $this->creditAccountFilter);
                })->orderBy('created_at', 'desc')
                ->simplePaginate($this->limitFilter);
        } else {
            return  ModelCreditTransaction::with(['creditAccount'])->when($this->nameFilter !== '', function ($query) {
                return $query->where('description', 'like', '%' . $this->nameFilter . '%')
                    ->orWhere('invoice_number', 'like', '%' . $this->nameFilter . '%')
                    ->orWhere('remarks', 'like', '%' . $this->nameFilter . '%');
            })
                ->when($this->creditAccountFilter !== '', function ($query) {
                    return $query->where('credit_account_id',  $this->creditAccountFilter);
                })->orderBy('created_at', 'desc')->get();
        }
    }

    public function mount()
    {
        $this->userId = Auth::id();
        $this->creditAccountList = PaymentMethod::orderBy('name', 'asc')->get();
        if ($this->creditAccountList) {
            $this->creditAccountId = $this->creditAccountList[0]->id;
        }
    }

    #[Title('Credit Transaction')]
    public function render()
    {
        return view(
            'livewire.credit-transaction',
            [
                "tableDataList" => $this->tableData()
            ]
        );
    }
}
