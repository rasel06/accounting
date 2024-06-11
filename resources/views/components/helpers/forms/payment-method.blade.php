@props(['statusOptions', 'selectedOption'])

<x-helpers.forms.panel wire:submit="save">

    <x-helpers.parts.input wire:model.live="name" label="Method Name" name="name" />
    <x-helpers.parts.select wire:model.change="status" label="Method status" name="status">
        @foreach ($statusOptions as $key => $value)
            <option value="{{ $key }}" {{ $key == $selectedOption ? 'selected' : '' }}>{{ $value }}
            </option>
        @endforeach
    </x-helpers.parts.select>

</x-helpers.forms.panel>
