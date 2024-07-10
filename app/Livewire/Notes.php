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

    public  $title, $isImportant, $storeId = '',  $accountId = '', $noteDate, $details,  $remarks;

    public $accountList = [];
    public $storeList = [];
    public $assetTypeList = [];

    public $paymentMethodFilter = '';

    public $tableFields = [
        'title' => ['title'],
        'store_id' => ['Store'],
        'account_id' => ['Account'],
        'is_important' => ['Important'],
        'note_date' => ['Date'],
        'details' => ['Details'],
        'remarks' => ['Remarks']
    ];

    protected $rules = [
        'title' => 'required',
        // 'storeId' => '',
        // 'accountId' => '',
        'isImportant' => 'required',
        'noteDate' => 'required|date',
        'details' => 'required',
        'remarks' => 'nullable|string',
    ];

    public function mount()
    {
        $this->getModule();

        $this->limitFilter = '';

        $this->userId = Auth::id();
        $this->accountList = PaymentMethod::orderBy('name', 'asc')->get();
        // if (count($this->accountList) > 0) {
        //     $this->accountId = $this->accountList[0]->id;
        // }

        $this->storeList = Store::with(['location'])->orderBy('name', 'asc')->get();
        // if (count($this->storeList) > 0) {
        //     $this->storeId = $this->storeList[0]->id;
        // $this->showModal = true;
        // }

        $this->showModal = true;
    }


    private function tableData()
    {
        if ($this->limitFilter != '') {
            return  ModelNote::with(['store', 'account'])
                ->when($this->nameFilter !== '', function ($query) {
                    return $query->where('description', 'like', '%' . $this->nameFilter . '%');
                })->when($this->paymentMethodFilter !== '', function ($query) {
                    return $query->where('payment_method_id',  $this->paymentMethodFilter);
                })->orderBy('created_at', 'desc')
                ->simplePaginate($this->limitFilter);
        } else {
            return  ModelNote::with(['store', 'account'])->when($this->nameFilter !== '', function ($query) {
                return $query->where('description', 'like', '%' . $this->nameFilter . '%');
                // ->orWhere('invoice_number', 'like', '%' . $this->nameFilter . '%')
                // ->orWhere('remarks', 'like', '%' . $this->nameFilter . '%');
            })
                ->when($this->paymentMethodFilter !== '', function ($query) {
                    return $query->where('payment_method_id',  $this->paymentMethodFilter);
                })->orderBy('created_at', 'desc')->get();
        }
    }




    // public function updating($field)
    // {
    //     dd($field);
    //     if ($field === 'showModal') {
    //         $this->dispatchBrowserEvent('contentChanged', ['id' => $this->id]);
    //     }
    // }



    #[Title('Notes')]
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

        $this->accountId = '';
        $this->storeId = '';
        $this->title = '';
        $this->noteDate = date('Y-m-d');
        $this->isImportant = false;
        $this->details = '';
        $this->remarks = '';
        $this->id = null;
    }


    public function store()
    {
        $this->validate();

        try {
            $processedData = [
                'title' => $this->title,
                'store_id' => $this->storeId,
                'account_id' => $this->accountId,
                'is_important' => $this->isImportant,
                'details' => $this->details,
                'note_date' => $this->noteDate,
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
            Log::error('Failed to store Note: ' . $e->getMessage());
            $this->notify('error');
        }
    }

    public function edit($id)
    {
        if ($id) {
            $note = ModelNote::findOrFail($id);

            // dd($note);

            $this->id = $id;
            $this->title = $note->title;
            $this->storeId = $note->store_id;
            $this->accountId = $note->account_id;
            $this->isImportant = $note->is_important;
            $this->noteDate = $note->note_date;
            $this->details = $note->details;
            $this->remarks = $note->remarks;
            $this->showModal = true;
        }
    }


    public function delete($id)
    {
        try {
            $selectedItem = ModelNote::findOrFail($id);
            $selectedItem->delete();
            $this->notify('success', 'delete');
        } catch (\Exception $e) {
            session()->flash('server_error', $e->getMessage());
            $this->notify('error', 'delete');
            Log::error('Failed to Delete Note : ' . $e->getMessage());
        }
    }
}
