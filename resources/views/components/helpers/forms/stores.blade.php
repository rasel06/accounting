@props(['statusList', 'selectedStatus', 'locations', 'selectedLocation'])



<x-helpers.forms.panel wire:submit="create">
    <x-helpers.parts.input wire:model="name" label="Store Name" name="name" />


    <x-helpers.parts.select wire:model.change="location_id" label="Store Location" name="location_id">
        @foreach ($locations as $key => $value)
            <option value="{{ $value->id }}" {{ $value->id == $selectedLocation ? 'selected' : '' }}>
                {{ $value->name }}
            </option>
        @endforeach
    </x-helpers.parts.select>

    <x-helpers.parts.select wire:model.change="status" label="Store Status" name="status">
        @foreach ($statusList as $key => $value)
            <option value="{{ $key }}" {{ $key == $selectedStatus ? 'selected' : '' }}>{{ $value }}
            </option>
        @endforeach
    </x-helpers.parts.select>

</x-helpers.forms.panel>
