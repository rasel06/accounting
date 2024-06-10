<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithoutUrlPagination;
use App\Models\PaymentMethod as PayMethods;
use Illuminate\Support\Facades\Auth;

class PaymentMethod extends Component
{

    use WithPagination, WithoutUrlPagination;

    public $title = "Payment Method";
    public $status = "";
    public $paymentName = "";
    // public $paymentMethods = [];
    public $userId;

    public $createMode = false;

    public $showModal = false;

    public $id;




    public function mount()
    {
        $this->userId = Auth::id();
        // $this->paymentMethods = PayMethods::paginate(10);
    }



    protected function tableData()
    {
        return  PayMethods::when($this->status !== '', function ($query) {
            return $query->where('status', $this->status);
        })->when($this->paymentName !== '', function ($query) {
            return $query->where('name', 'like', '%' . $this->paymentName . '%');
        })->paginate(8);
    }


    public function render()
    {
        return view('livewire.payment-method', [
            "paymentMethods" => $this->tableData()
        ]);
    }


    public function create()
    {
        $this->showModal = true;
    }

    public function details($id)
    {
        $this->id = $id;
    }

    public function edit($id)
    {
        $this->id = $id;
    }

    public function delete($id)
    {
        $this->id = $id;
    }

    public function modalClose()
    {
        $this->showModal = false;
    }
}
