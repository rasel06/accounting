<div class="">
    <div class="w-full h-fit ">
        <div class="max-w-full mx-auto sm:px-4 lg:px-3 bg-slate-300 rounded-lg ">
            <div class="flex flex-col items-stretch">
                <h1 class="text-xl font-bold text-cyan-500 py-2">Asset Types<span>::</span> </h1>
                <hr class="border-slate-500/40 ">

                <x-helpers.parts.data-table.control />

                <div class=" py-0  ">
                    <x-helpers.parts.data-table.table :tableItems="$assetTypesList" :$limitFilter :$tableFields />
                </div>
            </div>
        </div>

        {{-- Modal for create new item --}}

        @if ($showModal)
            <x-helpers.modal header="{{ $id == null ? 'Create New' : 'Update' }}">
                <x-helpers.forms.asset-type :statusList="$statusList" :selectedStatus="$status" />
            </x-helpers.modal>
        @endif
    </div>
</div>
