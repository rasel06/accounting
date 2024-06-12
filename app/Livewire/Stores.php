<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Livewire\Helpers\Modal;
use App\Models\Location;
use Illuminate\Validation\Rule;
use Livewire\WithoutUrlPagination;
use Illuminate\Support\Facades\Auth;
use App\Models\Store;

class Stores extends Component
{

    use WithPagination, WithoutUrlPagination, Modal;

    public $title = "Payment Method";
    public $id;
    public $userId;
    public $locations;

    public $selectedItem;

    public $statusOptions = ['' => 'Choose Status', 'active' => 'Active', 'inactive' => 'In Active'];

    public $tableFields = ['name' => 'Store Name', 'location->name' => 'Store Location', 'status' => 'Status'];

    // ---------------------- Table Filter Attributes ------------ >
    public $statusFilter = "";
    public $nameFilter = "";
    public $limitFilter = 10;
    public $locationFilter = "";

    // ----------------------  DB Attributes --------------------- >
    public $name = "";
    public $status = '';
    public $location_id = '';




    public function mount()
    {
        $this->userId = Auth::id();
        $this->locations = Location::where('status', 'active')->get();
    }

    public function clean()
    {
        $this->name = "";
        $this->status = '';
        $this->resetErrorBag();
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
                    Rule::unique('stores')->ignore($this->id),
                ],
                'status' => [
                    'required'
                ],
                'location_id' => [
                    'required'
                ],
            ]);
            if ($this->id) {
                $this->select($this->id);
                $this->selectedItem->update([
                    'name' => $this->name,
                    'user_id' => $this->userId,
                    'location_id' => $this->location_id,
                    'status' => $this->status
                ]);
                $this->showModal = false;
                $this->clean();
            } else {
                $pay_method = Store::create([
                    'name' => $this->name,
                    'user_id' => $this->userId,
                    'location_id' => $this->location_id,
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
        $this->id = $id;

        if ($id) {
            $this->select($id);
            $this->name = $this->selectedItem->name;
            $this->status = $this->selectedItem->status;
            $this->location_id = $this->selectedItem->location->id;
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
        $this->selectedItem = Store::find($id);;
    }


    protected function tableData()
    {
        if ($this->limitFilter != '') {
            return  Store::when($this->statusFilter !== '', function ($query) {
                return $query->where('status', $this->statusFilter);
            })->when($this->locationFilter !== '', function ($query) {
                return $query->where('location_id', $this->locationFilter);
            })->when($this->nameFilter !== '', function ($query) {
                return $query->where('name', 'like', '%' . $this->nameFilter . '%');
            })->orderBy('created_at', 'desc')
                ->simplePaginate($this->limitFilter);
        } else {
            return  Store::when($this->statusFilter !== '', function ($query) {
                return $query->where('status', $this->statusFilter);
            })->when($this->locationFilter !== '', function ($query) {
                return $query->where('location_id', $this->locationFilter);
            })->when($this->nameFilter !== '', function ($query) {
                return $query->where('name', 'like', '%' . $this->nameFilter . '%');
            })->orderBy('created_at', 'desc')->get();
        }
    }





    public function render()
    {
        return view('livewire.stores', [
            "paymentMethods" => $this->tableData()
        ]);
    }
}
