@props(['statusOptions', 'selectedOption'])



<x-helpers.forms.panel wire:submit="create">
    <x-helpers.parts.input wire:model="name" label="Asset Type" name="name" />
    <x-helpers.parts.select wire:model.change="status" label="Asset Type status" name="status">
        @foreach ($statusOptions as $key => $value)
            <option value="{{ $key }}" {{ $key == $selectedOption ? 'selected' : '' }}>{{ $value }}
            </option>
        @endforeach
    </x-helpers.parts.select>
</x-helpers.forms.panel>
