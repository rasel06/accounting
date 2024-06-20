@props(['statusList', 'selectedStatus'])

<x-helpers.forms.panel wire:submit="create">
    <x-helpers.parts.input label="Asset Type" name="name" />
    <x-helpers.parts.select wire:model.change="status" label="Asset Type Status" name="status">
        @foreach ($statusList as $key => $value)
            <option value="{{ $key }}" {{ $key == $selectedStatus ? 'selected' : '' }}>{{ $value }}
            </option>
        @endforeach
    </x-helpers.parts.select>
</x-helpers.forms.panel>
