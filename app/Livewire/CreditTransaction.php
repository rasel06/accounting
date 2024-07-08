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
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use App\Models\CreditTransaction as ModelCreditTransaction;

class CreditTransaction extends Component
{
    use WithPagination, WithoutUrlPagination, WithFileUploads, Modal;

    // ----------------------  DB Attributes --------------------- >
    public $creditAccountId, $description, $invoiceNumber, $invoiceDate, $invoiceFile, $amount, $remarks;

    public $creditAccountList = [];
    public $creditAccountFilter = "";

    public $tableFields = [
        'credit_account_id' => ['Credit Account'],
        'description' => ['Description'],
        'invoice_number' => ['Invoice Number'],
        'invoice_date' => ['Invoice Date'],
        'invoice_file' => ['Invoice Upload', 'w-10'],
        'amount' => ['Total'],
        'remarks' => ['Remarks']
    ];

    protected $rules = [
        'creditAccountId' => ['required'],
        'description' => ['required', 'min:2', 'string', 'max:255'],
        'invoiceNumber' => ['required', 'regex:/^DBC5\d{4}$/', 'unique:credit_transactions,invoice_number'],
        'invoiceDate' => ['required'],
        'amount' => ['required', 'numeric'],
        'remarks' => ['required', 'min:2', 'string', 'max:255'],
    ];


    public function mount()
    {
        $this->getModule();
        $this->userId = Auth::id();
        $this->creditAccountList = PaymentMethod::orderBy('name', 'asc')->get();
        if (count($this->creditAccountList) > 0) {
            $this->creditAccountId = $this->creditAccountList[0]->id;
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


    public function create()
    {
        $this->resetInputFields();
        $this->invoiceNumber = $this->generateNextInvoiceNumber();
        $this->showModal = true;
    }


    public function updated($propertyName)
    {
        if ($propertyName === 'invoiceNumber') {
            $this->invoiceNumber = strtoupper($this->invoiceNumber);
        }
    }



    public function resetInputFields()
    {

        if ($this->creditAccountList) {
            $this->creditAccountId = $this->creditAccountList[0]->id;
        } else {
            $this->creditAccountId = '';
        }

        $this->commonReset();
        $this->creditAccountId = $this->creditAccountList[0]->id;
        $this->description = "";
        $this->invoiceNumber = "";
        $this->invoiceFile = "";
        $this->invoiceDate = "";
        $this->amount = "";
        $this->remarks = "";
        $this->id = null;
    }


    public function reGenerate($type = 1)
    {
        if ($type == 1) {
            $this->invoiceNumber = $this->generateNextInvoiceNumber();
        }
    }

    public function store()
    {

        if ($this->id) {
            $this->rules['invoiceNumber'] = ['required', 'regex:/^DBC5\d{5}$/', 'unique:credit_transactions,invoice_number,' . $this->id];
        }

        if (gettype($this->invoiceFile) !== 'string' && $this->invoiceFile) {
            $this->rules['invoiceFile'] = 'required|max:1024';
        }

        $this->validate();

        try {

            $filePath = "";
            if (gettype($this->invoiceFile) !== 'string' && $this->invoiceFile) {
                $uploadedFileName = $this->invoiceNumber . '.' . $this->invoiceFile->guessExtension();
                $filePath = $this->invoiceFile->storeAs('/invoices/credit', $uploadedFileName);
            }

            $processedData = [
                'credit_account_id' => $this->creditAccountId,
                'description' => $this->description,
                'invoice_number' => $this->invoiceNumber,
                'invoice_date' => $this->invoiceDate,
                'amount' => $this->amount,
                'user_id' => $this->userId,
                'remarks' => $this->remarks,
                'invoice_file' => $filePath
            ];

            if ($this->id && gettype($this->invoiceFile) === 'string') {
                unset($processedData['invoice_file']);
            }

            if (!$this->id) {
                $processedData['user_id'] = $this->userId;
            }

            ModelCreditTransaction::updateOrCreate(['id' => $this->id], $processedData);
            $this->notify();
            $this->showModal = false;
            $this->resetInputFields();
        } catch (\Exception $e) {
            Log::error('Failed to store Credit transaction: ' . $e->getMessage());
            $this->notify('error');
        }
    }


    public function edit($id = null)
    {
        if ($id) {
            $selectedItem = ModelCreditTransaction::findOrFail($id);
            $this->selectedId = $selectedItem->invoice_number;

            $this->id = $id;
            $this->creditAccountId = $selectedItem->credit_account_id;
            $this->description = $selectedItem->description;
            $this->invoiceNumber = $selectedItem->invoice_number;
            $this->invoiceFile =  $selectedItem->invoice_file;
            $this->invoiceDate = $selectedItem->invoice_date;
            $this->amount = $selectedItem->amount;
            $this->remarks = $selectedItem->remarks;

            $this->showModal = true;
        }
    }

    public function delete($id = null)
    {
        if ($id) {
            try {
                $selectedItem = ModelCreditTransaction::findOrFail($id);

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
                Log::error('Failed to Delete Credit transaction: ' . $e->getMessage());
                $this->notify('error', 'delete');
            }
        }
    }
}
