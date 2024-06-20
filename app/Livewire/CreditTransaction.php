<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\PaymentMethod;
use Livewire\WithFileUploads;
use App\Livewire\Helpers\Modal;
use Livewire\WithoutUrlPagination;
use Illuminate\Support\Facades\Auth;
use App\Models\CreditTransaction as ModelCreditTransaction;

class CreditTransaction extends Component
{

    use WithPagination, WithoutUrlPagination, WithFileUploads, Modal;

    public $title = "Credit Transaction";

    public $tableFields = [
        'credit_account_id' => 'Credit Account',
        //  'description' => 'Description',
        'invoice_number' => 'Invoice Number',
        'amount' => 'Amount',
        // 'unit_price' => 'Unit Price',
        // 'total' => 'Total',
        'remarks' => 'Remarks',
        'upload_file' => 'Upload File',
    ];

    // ----------------------  DB Attributes --------------------- >
    public $creditAccountId;
    public $description;
    public $invoiceNumber;
    public $invoiceDate;
    public $invoiceFile;
    public $amount;
    public $remarks;

    public $creditAccountList = [];

    protected $listeners = [
        'deletePostListner' => 'deletePost'
    ];

    public function updated($propertyName)
    {
        if ($propertyName === 'invoiceNumber') {
            $this->invoiceNumber = strtoupper($this->invoiceNumber);
        }
    }

    protected $rules = [
        'creditAccountId' => ['required'],
        'description' => ['required', 'min:2', 'string', 'max:255'],
        'invoiceNumber' => ['required', 'regex:/^DBC5\d{5}$/', 'unique:credit_transactions,invoice_number'],
        'invoiceDate' => ['required'],
        'amount' => ['required', 'numeric'],
        'remarks' => ['required', 'min:2', 'string', 'max:255'],
    ];

    public function resetFields()
    {
        $this->commonClean();
        $this->creditAccountId = $this->creditAccountList[0]->id;
        $this->description = "";
        $this->invoiceNumber = "";
        $this->invoiceFile = "";
        $this->invoiceDate = "";
        $this->amount = "";
        $this->remarks = "";
    }

    public function create()
    {
        $this->resetFields();
        $this->addMode = true;
        $this->editMode = false;
        $this->showModal = true;
    }

    public function store()
    {
        $this->validate();
        try {
            $uploadedFileName = $this->invoiceNumber . '.' .
                $this->invoiceFile->guessExtension();

            $invoiceFilePath = $this->invoiceFile->storeAs(path: '/invoices', name: $uploadedFileName);

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
            session()->flash('success', 'Transactio Added Successfully!!');
            $this->resetFields();
            $this->addMode = false;
        } catch (\Exception $ex) {
            session()->flash('error', 'Something goes wrong!!');
        }
    }

    protected function tableData()
    {
        if ($this->limitFilter != '') {
            return  ModelCreditTransaction::with(['creditAccount'])->when($this->nameFilter !== '', function ($query) {
                return $query->where('description', 'like', '%' . $this->nameFilter . '%');
            })->orderBy('created_at', 'desc')
                ->simplePaginate($this->limitFilter);
        } else {
            return  ModelCreditTransaction::with(['creditAccount'])->when($this->nameFilter !== '', function ($query) {
                return $query->where('description', 'like', '%' . $this->nameFilter . '%');
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
