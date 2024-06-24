<div>
    <div class="w-full mx-auto px-4  bg-slate-300 rounded-lg ">
        <div class="flex flex-col items-stretch">
            <h1 class="text-xl font-bold text-cyan-500 py-2">Stores <span>::</span> </h1>
            <hr class="border-slate-500/40 ">

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
        </div>
    </div>

    @if ($showModal)
        <x-helpers.modal :id>
            <x-helpers.forms.stores :statusList="$statusList" :selectedStatus="$status" :$locations :selectedLocation="$location_id" />
        </x-helpers.modal>
    @endif

</div>
