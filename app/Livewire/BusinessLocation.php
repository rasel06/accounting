<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Location;
use Livewire\WithPagination;
use Livewire\Attributes\Title;
use App\Livewire\Helpers\Modal;
use Livewire\WithoutUrlPagination;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class BusinessLocation extends Component
{

    use WithPagination, WithoutUrlPagination, Modal;

    public $name = "";

    public $tableFields = ['name' => 'Business Location', 'status' => 'Status'];


    protected $rules = [
        'name' => [
            'required',
            'min:2',
            'string',
            'max:255',
            'unique:locations,name'
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
            $this->rules['name'] = ['required', 'unique:locations,name,' . $this->id];
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

            Location::updateOrCreate(['id' => $this->id], $processedData);
            $this->notify();
            $this->showModal = false;
            $this->resetInputFields();
        } catch (\Exception $e) {
            Log::error('Failed to store Location: ' . $e->getMessage());
            $this->notify('error');
        }
    }


    public function edit($id = null)
    {
        if ($id) {
            $location = Location::findOrFail($id);
            $this->id = $id;
            $this->name = $location->name;
            $this->status = $location->status;

            $this->showModal = true;
        }
    }

    public function delete($id = null)
    {
        try {
            $location = Location::findOrFail($id);
            $location->delete();
            $this->notify('success', 'delete');
        } catch (\Exception $e) {
            session()->flash('server_error', $e->getMessage());
            $this->notify('error', 'delete');
            Log::error('Failed to Delete Location : ' . $e->getMessage());
        }
    }
}
