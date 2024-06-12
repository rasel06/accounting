<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Livewire\Helpers\Modal;
use App\Models\AssetType as ModelAssetType;
use Illuminate\Validation\Rule;
use Livewire\WithoutUrlPagination;
use Illuminate\Support\Facades\Auth;


class AssetType extends Component
{

    use WithPagination, WithoutUrlPagination, Modal;

    public $title = "Asset Types";
    public $id;
    public $userId;

    public $selectedItem;

    public $statusOptions = ['' => 'Choose Status', 'active' => 'Active', 'inactive' => 'In Active'];
    public $tableFields = ['name' => 'Asset Types', 'status' => 'Status'];

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
                    Rule::unique('asset_types')->ignore($this->id),
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
                $this->clean();
            } else {
                $pay_method = ModelAssetType::create([
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
        $this->selectedItem = ModelAssetType::find($id);;
    }


    protected function tableData()
    {
        if ($this->limitFilter != '') {
            return  ModelAssetType::when($this->statusFilter !== '', function ($query) {
                return $query->where('status', $this->statusFilter);
            })->when($this->nameFilter !== '', function ($query) {
                return $query->where('name', 'like', '%' . $this->nameFilter . '%');
            })
                ->orderBy('created_at', 'desc')
                ->simplePaginate($this->limitFilter);
        } else {
            return  ModelAssetType::when($this->statusFilter !== '', function ($query) {
                return $query->where('status', $this->statusFilter);
            })->when($this->nameFilter !== '', function ($query) {
                return $query->where('name', 'like', '%' . $this->nameFilter . '%');
            })->orderBy('created_at', 'desc')->get();
        }
    }



    public function render()
    {
        return view('livewire.asset-type', [
            "paymentMethods" => $this->tableData()
        ]);
    }
}
