<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Title;
use App\Livewire\Helpers\Modal;
use Illuminate\Validation\Rule;
use Livewire\WithoutUrlPagination;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use App\Models\PaymentMethod as ModelPaymentMethod;

class PaymentMethod extends Component
{

    use WithPagination, WithoutUrlPagination, Modal;



    public $selectedPayMethod;

    public $tableFields = ['name' => 'Payment Method', 'status' => 'Status'];

    // ----------------------  DB Attributes --------------------- >
    public $name = "";


    protected $rules = [
        'name' => [
            'required',
            'min:2',
            'string',
            'max:255',
            'unique:payment_methods,name'
        ],
        'status' => [
            'required'
        ],
    ];


    public function mount()
    {
        $this->getModule();
        $this->userId = Auth::id();
    }



    public function resetInputFields()
    {
        $this->commonReset();
        $this->name = "";
    }


    public function create($init = null)
    {
        $this->resetInputFields();
        $this->showModal = true;
    }

    public function store()
    {
        if ($this->id) {
            $this->rules['name'] = ['required', 'unique:payment_methods,name,' . $this->id];
        }

        $this->validate();

        try {
            $processedData = [
                'name' => $this->name,
                'status' => $this->status,
            ];

            if (!$this->id) {
                $processedData['user_id'] = $this->userId;
            }

            ModelPaymentMethod::updateOrCreate(['id' => $this->id], $processedData);
            $this->notify();
            $this->showModal = false;
            $this->resetInputFields();
        } catch (\Exception $e) {
            Log::error('Failed to Payment Methods: ' . $e->getMessage());
            $this->notify('error');
        }
    }


    public function edit($id = null)
    {
        if ($id) {
            $location = ModelPaymentMethod::findOrFail($id);
            $this->id = $id;
            $this->name = $location->name;
            $this->status = $location->status;

            $this->showModal = true;
        }
    }

    public function delete($id = null)
    {
        try {
            $location = ModelPaymentMethod::findOrFail($id);
            $location->delete();
            $this->notify('success', 'delete');
        } catch (\Exception $e) {
            session()->flash('server_error', $e->getMessage());
            $this->notify('error', 'delete');
            Log::error('Failed to Payment Methods : ' . $e->getMessage());
        }
    }





    protected function tableData()
    {
        if ($this->limitFilter != '') {
            return  ModelPaymentMethod::when($this->statusFilter !== '', function ($query) {
                return $query->where('status', $this->statusFilter);
            })->when($this->nameFilter !== '', function ($query) {
                return $query->where('name', 'like', '%' . $this->nameFilter . '%');
            })
                ->orderBy('created_at', 'desc')
                ->simplePaginate($this->limitFilter);
        } else {
            return  ModelPaymentMethod::when($this->statusFilter !== '', function ($query) {
                return $query->where('status', $this->statusFilter);
            })->when($this->nameFilter !== '', function ($query) {
                return $query->where('name', 'like', '%' . $this->nameFilter . '%');
            })->orderBy('created_at', 'desc')->get();
        }
    }

    #[Title('Payment Method')]
    public function render()
    {
        return view('livewire.payment-method', [
            "paymentMethods" => $this->tableData()
        ]);
    }
}
