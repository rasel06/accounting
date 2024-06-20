@props(['statusList', 'selectedStatus', 'locations', 'selectedLocation'])



<x-helpers.forms.panel wire:submit="create">
    <x-helpers.parts.input label="Country Name" name="name" />
    <x-helpers.parts.select wire:model.change="status" label="Country Status" name="status">
        @foreach ($statusList as $key => $value)
            <option value="{{ $key }}" {{ $key == $selectedStatus ? 'selected' : '' }}>{{ $value }}
            </option>
        @endforeach
    </x-helpers.parts.select>

</x-helpers.forms.panel>
