<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Livewire\Helpers\Modal;
use Illuminate\Validation\Rule;
use Livewire\WithoutUrlPagination;
use Illuminate\Support\Facades\Auth;
use App\Models\Location;
use Livewire\Attributes\Title;

class BusinessLocation extends Component
{

    use WithPagination, WithoutUrlPagination, Modal;

    public $title = "Business Location";
    public $selectedItem;

    public $tableFields = ['name' => 'Business Location', 'status' => 'Status'];

    // ---------------------- Table Filter Attributes ------------ >
    public $statusFilter = "";
    public $nameFilter = "";
    public $limitFilter = 10;

    // ----------------------  DB Attributes --------------------- >
    public $name = "";




    public function mount()
    {
        $this->userId = Auth::id();
    }

    public function resetFields()
    {
        $this->commonReset();
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
                    Rule::unique('locations')->ignore($this->id),
                ],
                'status' => [
                    'required'
                ],
            ]);
            if ($this->id) {
                $this->select($this->id);
                $this->selectedItem->update([
                    'name' => $this->name,
                    'user_id' => $this->userId,
                    'status' => $this->status
                ]);
                $this->showModal = false;
                $this->resetFields();
            } else {
                $pay_method = Location::create([
                    'name' => $this->name,
                    'user_id' => $this->userId,
                    'status' => $this->status
                ]);
                if ($pay_method->id > 0) {
                    $this->showModal = false;
                    $this->resetFields();
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
        $this->selectedItem = Location::find($id);;
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

    #[Title('Business Location')]
    public function render()
    {
        return view('livewire.locations', [
            "businessLocation" => $this->tableData()
        ]);
    }
}
