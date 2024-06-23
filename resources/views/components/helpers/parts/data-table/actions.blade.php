@props(['id', 'smallIcon' => false])

@php
    $iconSmall = '';

    if ($smallIcon === true) {
        $iconSmall = ' small-icon';
    }
@endphp


<div role="group" class="text-gray-600 flex ">
    <x-helpers.parts.data-table.button wire:click="details({{ $id }})" class="rounded-l-lg text-purple-600/60 ">
        <span class="material-symbols-outlined {{ $iconSmall }}">description</span>
    </x-helpers.parts.data-table.button>

    <x-helpers.parts.data-table.button wire:click="edit({{ $id }})" class="text-green-600/60 ">
        <span class="material-symbols-outlined  {{ $iconSmall }}">edit</span>
    </x-helpers.parts.data-table.button>

    <x-helpers.parts.data-table.button wire:click="delete({{ $id }})" wire:confirm="Really want to delete?"
        class="rounded-r-lg text-rose-600/60">
        <span class="material-symbols-outlined {{ $iconSmall }}">delete</span>
    </x-helpers.parts.data-table.button>

</div>
