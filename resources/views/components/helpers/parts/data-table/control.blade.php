<div class="flex flex-wrap flex-grow justify-between">
    <div class="flex items-center py-2">
        <input wire:model.live="nameFilter"
            class="bg-gray-100 appearance-none border-2 border-gray-100 rounded w-1/2 py-1 px-2 text-gray-700 leading-tight focus:outline-none focus:bg-white focus:border-gray-300"
            id="inline-search" type="text" placeholder="Search">

        <select wire:model.change="statusFilter"
            class="border-gray-100 rounded ml-2 py-1 pr-8 text-gray-700 leading-tight focus:outline-none focus:bg-white focus:border-gray-300">
            <option value="">All</option>
            <option value="active">Active</option>
            <option value="inactive">In Active</option>
        </select>

        <select wire:model.change="limitFilter"
            class="border-gray-100 rounded ml-2 py-1 pr-8 text-gray-700 leading-tight focus:outline-none focus:bg-white focus:border-gray-300">
            <option value="5">5</option>
            <option value="10">10</option>
            <option value="20">20</option>
            <option value="50">50</option>
            <option value="">All</option>
        </select>

        {{ $slot }}

    </div>

    <div class="flex items-center py-2">
        <button wire:click="create(1)"
            class="inline-block px-2 py-1 border border-transparent text-sm leading-5 font-medium rounded-md text-white bg-cyan-600 hover:bg-cyan-500 focus:outline-none focus:shadow-outline">
            <div class="flex justify-center gap-2 items-center">
                Create
                <span class="material-symbols-outlined">add</span>
            </div>
        </button>
    </div>
</div>
