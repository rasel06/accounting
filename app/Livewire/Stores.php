<?php

namespace App\Livewire;

use App\Models\Store;
use Livewire\Component;
use App\Models\Location;
use Livewire\WithPagination;
use Livewire\Attributes\Title;
use App\Livewire\Helpers\Modal;
use Illuminate\Validation\Rule;
use Livewire\WithoutUrlPagination;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class Stores extends Component
{

    use WithPagination, WithoutUrlPagination, Modal;

    public $tableFields = ['name' => 'Store Name', 'location->name' => 'Store Location', 'status' => 'Status'];

    public $locations;
    public $locationFilter = "";

    public $name = "";
    public $location_id = '';


    protected $rules = [
        'name' => [
            'required',
            'min:2',
            'string',
            'max:255',
            'unique:stores,name'
        ],
        'status' => [
            'required'
        ],
        'location_id' => [
            'required'
        ]
    ];


    public function mount()
    {
        $this->getModule();
        $this->userId = Auth::id();

        $this->locations = Location::where('status', 'active')
            ->orderBy('name', 'asc')
            ->get();
        if (count($this->locations) > 0) {
            $this->location_id = $this->locations[0]->id;
        }
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

    public function resetInputFields()
    {
        $this->commonReset();
        $this->name = "";
        if ($this->locations) {
            $this->location_id = $this->locations[0]->id;
        }
    }


    public function create($init = null)
    {
        $this->resetInputFields();
        $this->showModal = true;

        /*
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
                $this->resetFields();
            } else {
                $pay_method = Store::create([
                    'name' => $this->name,
                    'user_id' => $this->userId,
                    'location_id' => $this->location_id,
                    'status' => $this->status
                ]);
                if ($pay_method->id > 0) {
                    $this->showModal = false;
                    $this->resetFields();
                }
            }
        }
        */
    }


    public function store()
    {
        if ($this->id) {
            $this->rules['name'] = ['required', 'unique:stores,name,' . $this->id];
        }

        $this->validate();

        try {
            $processedData = [
                'name' => $this->name,
                'user_id' => $this->userId,
                'location_id' => $this->location_id,
                'status' => $this->status
            ];

            if (!$this->id) {
                $processedData['user_id'] = $this->userId;
            }

            Store::updateOrCreate(['id' => $this->id], $processedData);
            $this->notify();
            $this->showModal = false;
            $this->resetInputFields();
        } catch (\Exception $e) {
            Log::error('Failed to Create / Update Stores: ' . $e->getMessage());
            $this->notify('error');
        }
    }

    public function edit($id = null)
    {

        if ($id) {
            $store = Store::findOrFail($id);
            $this->id = $id;
            $this->name = $store->name;
            $this->status = $store->status;
            $this->location_id = $store->location->id;

            $this->showModal = true;
        }
    }

    public function delete($id = null)
    {
        if ($id) {
            try {
                $location = Store::findOrFail($id);
                $location->delete();
                $this->notify('success', 'delete');
            } catch (\Exception $e) {
                session()->flash('server_error', $e->getMessage());
                $this->notify('error', 'delete');
                Log::error('Failed to Delete Store : ' . $e->getMessage());
            }
        }
    }


    #[Title('Stores')]
    public function render()
    {
        return view('livewire.stores', [
            "storeList" => $this->tableData()
        ]);
    }
}
