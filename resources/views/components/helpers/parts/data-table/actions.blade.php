@props(['id'])



<div role="group" class="text-gray-600 flex">
    <x-helpers.parts.data-table.button wire:click="details({{ $id }})" class="rounded-l-lg text-purple-600/60 ">
        <span class="material-symbols-outlined ">description</span>
    </x-helpers.parts.data-table.button>

    <x-helpers.parts.data-table.button wire:click="edit({{ $id }})" class="text-green-600/60 ">
        <span class="material-symbols-outlined ">edit</span>
    </x-helpers.parts.data-table.button>

    <x-helpers.parts.data-table.button wire:click="delete({{ $id }})" wire:confirm="Really want to delete?"
        class="rounded-r-lg text-rose-600/60">
        <span class="material-symbols-outlined ">delete</span>
    </x-helpers.parts.data-table.button>

</div>
