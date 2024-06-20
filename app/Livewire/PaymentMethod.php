<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Livewire\Helpers\Modal;
use Illuminate\Validation\Rule;
use Livewire\WithoutUrlPagination;
use Illuminate\Support\Facades\Auth;
use App\Models\PaymentMethod as PayMethods;

class PaymentMethod extends Component
{

    use WithPagination, WithoutUrlPagination, Modal;

    public $title = "Payment Method";
    // public $id;
    // public $userId;

    public $selectedPayMethod;

    public $tableFields = ['name' => 'Payment Method', 'status' => 'Status'];

    // ----------------------  DB Attributes --------------------- >
    public $name = "";



    public function mount()
    {
        $this->userId = Auth::id();
    }

    public function clean()
    {
        $this->commonClean();
        $this->name = "";
    }


    public function create($init = null)
    {
        $this->showModal = true;

        if ($init == null) {
            $this->validate([
                'name' => [
                    'required',
                    'min:2',
                    'string',
                    'max:255',
                    Rule::unique('payment_methods')->ignore($this->id),
                ],
                'status' => [
                    'required'
                ],
            ]);
            if ($this->id) {
                $this->select($this->id);
                $this->selectedPayMethod->update([
                    'name' => $this->name,
                    'user_id' => $this->userId,
                    'status' => $this->status
                ]);
                $this->showModal = false;
                $this->clean();
            } else {
                $pay_method = PayMethods::create([
                    'name' => $this->name,
                    'user_id' => $this->userId,
                    'status' => $this->status
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
        if ($id) {
            $this->id = $id;
            $this->select($id);
            $this->name = $this->selectedPayMethod->name;
            $this->status = $this->selectedPayMethod->status;
            $this->showModal = true;
        }
    }

    public function delete($id = null)
    {
        if ($id) {
            $this->select($id);
            $this->selectedPayMethod->delete();
        }
    }

    protected function select($id)
    {
        $this->selectedPayMethod = PayMethods::find($id);
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
            })->orderBy('created_at', 'desc')->get();
        }
    }



    public function render()
    {
        return view('livewire.payment-method', [
            "paymentMethods" => $this->tableData()
        ]);
    }
}
