<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Livewire\Helpers\Modal;
use Illuminate\Validation\Rule;
use Livewire\WithoutUrlPagination;
use Illuminate\Support\Facades\Auth;
use App\Models\Location;

class Locations extends Component
{

    use WithPagination, WithoutUrlPagination, Modal;

    public $title = "Business Location";
    public $id;
    public $userId;

    public $selectedLocation;

    public $statusOptions = ['' => 'Choose Status', 'active' => 'Active', 'inactive' => 'In Active'];
    public $tableFields = ['name' => 'Business Location', 'status' => 'Status'];




    // ---------------------- Table Filter Attributes ------------ >
    public $statusFilter = "";
    public $nameFilter = "";
    public $limitFilter = 10;

    // ----------------------  DB Attributes --------------------- >
    public $name = "";
    public $status = '';



    public function mount()
    {
        $this->userId = Auth::id();
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
                    Rule::unique('locations')->ignore($this->id),
                ],
                'status' => [
                    'required'
                ],
            ]);
            if ($this->id) {
                $this->select($this->id);
                $this->selectedLocation->update([
                    'name' => $this->name,
                    'user_id' => $this->userId,
                    'status' => $this->status
                ]);
                $this->showModal = false;
                $this->clean();
            } else {
                $pay_method = Location::create([
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
        $this->id = $id;

        if ($id) {
            $this->select($id);
            $this->name = $this->selectedLocation->name;
            $this->status = $this->selectedLocation->status;
        }

        $this->showModal = true;
    }

    public function delete($id = null)
    {
        if ($id) {
            $this->select($id);
            $this->selectedLocation->delete();
        }
    }

    protected function select($id)
    {
        $this->selectedLocation = Location::find($id);;
    }


    protected function tableData()
    {
        if ($this->limitFilter != '') {
            return  Location::when($this->statusFilter !== '', function ($query) {
                return $query->where('status', $this->statusFilter);
            })->when($this->nameFilter !== '', function ($query) {
                return $query->where('name', 'like', '%' . $this->nameFilter . '%');
            })
                ->orderBy('created_at', 'desc')
                ->simplePaginate($this->limitFilter);
        } else {
            return  Location::when($this->statusFilter !== '', function ($query) {
                return $query->where('status', $this->statusFilter);
            })->when($this->nameFilter !== '', function ($query) {
                return $query->where('name', 'like', '%' . $this->nameFilter . '%');
            })->orderBy('created_at', 'desc')->get();
        }
    }



    public function render()
    {
        return view('livewire.locations', [
            "paymentMethods" => $this->tableData()
        ]);
    }
}
