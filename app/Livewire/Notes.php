<?php

namespace App\Livewire;

use App\Models\Store;
use Livewire\Component;
use App\Models\AssetType;
use Livewire\Attributes\On;
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
    use WithPagination, WithoutUrlPagination, Modal;

    public  $title, $isImportant, $storeId = null,  $accountId = null, $noteDate, $details,  $remarks;

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
        'storeId' => 'nullable',
        'accountId' => 'nullable',
        // 'isImportant' => 'required',
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

        $this->storeList = Store::with(['location'])->orderBy('name', 'asc')->get();
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
        // $this->showModal = true;
        $this->dispatch('toggle-modal', value: true);
    }



    private function resetInputFields()
    {
        $this->accountId = null;
        $this->storeId = null;
        $this->title = '';
        $this->noteDate = date('Y-m-d');
        $this->isImportant = null;
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
                'is_important' => ($this->isImportant == '') ? 0 : $this->isImportant,
                'details' => $this->details,
                'note_date' => $this->noteDate,
                'remarks' => $this->remarks,
            ];

            // dd($this->isImportant);

            if (!$this->id) {
                $processedData['user_id'] = $this->userId;
            }

            ModelNote::updateOrCreate(['id' => $this->id], $processedData);
            $this->notify();
            // $this->showModal = false;
            $this->dispatch('toggle-modal', value: false);
            $this->resetInputFields();
        } catch (\Exception $e) {
            Log::error('Failed to store Note: ' . $e->getMessage());
            $this->notify('error');
        }
    }

    #[On('toggle-modal',)]
    public function modalControl($value = false)
    {
        $this->showModal = $value;
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
            // $this->showModal = true;
            // $this->toggleModal();
            $this->dispatch('toggle-modal', value: true);
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
