<?php

namespace App\Livewire;

use Livewire\Component;

use Livewire\WithPagination;
use App\Livewire\Helpers\Modal;
use Livewire\Attributes\Validate;
use App\Livewire\Helpers\CrudAble;
use Livewire\WithoutUrlPagination;
use Illuminate\Support\Facades\Auth;
use App\Models\PaymentMethod as PayMethods;


class PaymentMethod extends Component
{

    use WithPagination, WithoutUrlPagination, Modal;

    public $title = "Payment Method";
    public $id;
    public $userId;

    public $statusOptions = ['' => 'Choose Status', 'active' => 'Active', 'inactive' => 'In Active'];

    // ---------------------- Table Filter Attributes ------------ >
    public $statusFilter = "";
    public $nameFilter = "";
    public $limitFilter = 10;

    // ----------------------  DB Attributes --------------------- >

    #[Validate('required', message: 'Please Provide Method Name')]
    #[Validate('min:2', message: 'This Method Name is too short')]
    #[Validate('max:400', message: 'This Method Name is too Long')]
    #[Validate('unique:payment_methods,name', message: 'This Method Name is Exist')]
    public $name = "";

    #[Validate('required', message: 'Please Provide Status')]
    public $status = '';


    public function mount()
    {
        $this->userId = Auth::id();
    }

    protected function tableData()
    {
        if ($this->limitFilter != '') {
            return  PayMethods::when($this->statusFilter !== '', function ($query) {
                return $query->where('status', $this->statusFilter);
            })->when($this->nameFilter !== '', function ($query) {
                return $query->where('name', 'like', '%' . $this->nameFilter . '%');
            })
                ->orderBy('created_at', 'desc')
                ->simplePaginate($this->limitFilter);
        } else {
            return  PayMethods::when($this->statusFilter !== '', function ($query) {
                return $query->where('status', $this->statusFilter);
            })->when($this->nameFilter !== '', function ($query) {
                return $query->where('name', 'like', '%' . $this->nameFilter . '%');
            })
                ->orderBy('created_at', 'desc');
        }
    }

    public function clean()
    {
        $this->name = "";
        $this->status = '';
    }

    public function create()
    {
        $this->editMode = false;
        $this->showModal = true;
    }

    public function save()
    {
        $this->validate();

        $user = PayMethods::create([
            'name' => $this->name,
            'user_id' => $this->userId,
            'status' => $this->status
        ]);

        if ($user->id > 0) {
            $this->editMode = true;
            $this->showModal = false;
            $this->clean();
        } else {
        }

        // return redirect()->to('/payment-method');
        // $this->editMode = false;
        // $this->showModal = true;
    }

    public function edit()
    {
        $this->editMode = true;
        $this->showModal = true;
    }


    public function render()
    {
        return view('livewire.payment-method', [
            "paymentMethods" => $this->tableData()
        ]);
    }
}
