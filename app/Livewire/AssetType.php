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
use App\Livewire\Helpers\CommonFields;
use App\Models\AssetType as ModelAssetType;


class AssetType extends Component
{

    use WithPagination, WithoutUrlPagination, Modal;

    public $name = "";

    public $tableFields = ['name' => 'Asset Types', 'status' => 'Status'];


    protected $rules = [
        'name' => [
            'required',
            'min:2',
            'string',
            'max:255',
            'unique:asset_types,name'
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
            $this->rules['name'] = ['required', 'unique:asset_types,name,' . $this->id];
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

            ModelAssetType::updateOrCreate(['id' => $this->id], $processedData);
            $this->notify();
            $this->showModal = false;
            $this->resetInputFields();
        } catch (\Exception $e) {
            Log::error('Failed to Asset Types: ' . $e->getMessage());
            $this->notify('error');
        }
    }


    public function edit($id = null)
    {
        if ($id) {
            $location = ModelAssetType::findOrFail($id);
            $this->id = $id;
            $this->name = $location->name;
            $this->status = $location->status;

            $this->showModal = true;
        }
    }

    public function delete($id = null)
    {
        try {
            $location = ModelAssetType::findOrFail($id);
            $location->delete();
            $this->notify('success', 'delete');
        } catch (\Exception $e) {
            session()->flash('server_error', $e->getMessage());
            $this->notify('error', 'delete');
            Log::error('Failed to Asset Types : ' . $e->getMessage());
        }
    }



    #[Title('Asset Types')]
    public function render()
    {
        return view('livewire.asset-type', [
            "assetTypesList" => $this->tableData()
        ]);
    }
}
