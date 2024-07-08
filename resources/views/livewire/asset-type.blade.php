<x-helpers.parts.content-panel>

    <x-slot name="heading">Asset Types</x-slot>

    <x-helpers.parts.data-table.control />
    <x-helpers.parts.data-table.table :tableItems="$assetTypesList" :$limitFilter :$tableFields />

    {{-- <div class="bg-slate-300 w-full h-40 flex gap-4 justify-between pb-4">
        <div class="w-1/2 bg-white rounded-lg">Cash</div>
        <div class="w-1/2 bg-white rounded-lg">Inventory</div>
    </div> --}}

    <x-slot name="modal">
        <x-helpers.modal :id>
            <x-helpers.forms.asset-type :statusList="$statusList" :selectedStatus="$status" />
        </x-helpers.modal>
    </x-slot>

</x-helpers.parts.content-panel>
