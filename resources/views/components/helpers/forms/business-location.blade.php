@props(['statusOptions', 'selectedOption', 'locations', 'selectedLocation'])



<x-helpers.forms.panel wire:submit="create">
    <x-helpers.parts.input wire:model="name" label="Country Name" name="name" />
    <x-helpers.parts.select wire:model.change="status" label="Country Status" name="status">
        @foreach ($statusOptions as $key => $value)
            <option value="{{ $key }}" {{ $key == $selectedOption ? 'selected' : '' }}>{{ $value }}
            </option>
        @endforeach
    </x-helpers.parts.select>

    <x-helpers.parts.select wire:model.change="location_id" label="Country Status" name="location_id">
        @foreach ($locations as $key => $value)
            <option value="{{ $value->id }}" {{ $value->id == $selectedLocation ? 'selected' : '' }}>
                {{ $value->name }}
            </option>
        @endforeach
    </x-helpers.parts.select>


</x-helpers.forms.panel>
