<x-helpers.parts.content-panel>

    <x-slot name="heading">Stores</x-slot>

    <x-helpers.parts.data-table.control>
        <select wire:model.change="locationFilter"
            class="border-gray-100 rounded ml-2 py-1 pr-8 text-gray-700 leading-tight focus:outline-none focus:bg-white focus:border-gray-300">
            <option value="">All</option>
            @foreach ($locations as $location)
                <option value="{{ $location->id }}">{{ $location->name }}</option>
            @endforeach
        </select>
    </x-helpers.parts.data-table.control>

    <x-helpers.parts.data-table.store-table :tableItems="$storeList" :$limitFilter :$tableFields />


    <x-slot name="modal">
        <x-helpers.modal :id>
            <x-helpers.forms.stores :statusList="$statusList" :selectedStatus="$status" :$locations :selectedLocation="$location_id" />
        </x-helpers.modal>
    </x-slot>

</x-helpers.parts.content-panel>
