<div class="w-full h-fit">
    <div class="w-full mx-auto sm:px-4 lg:px-3 bg-slate-300 rounded-lg ">
        <div class="flex flex-col items-stretch">
            <h1 class="text-xl font-bold text-cyan-500 py-2">Credit Transaction <span>::</span> </h1>
            <hr class="border-slate-500/40 ">

            <x-helpers.parts.data-table.control :showStatus="false" />

            <x-helpers.parts.data-table.credit-transaction-table :tableItems="$tableDataList" :$limitFilter :$tableFields />
        </div>
    </div>

    {{-- Modal for create new item --}}

    @if ($showModal)
        <x-helpers.modal header="{{ $id == null ? 'Create New' : 'Update' }}">
            <x-helpers.forms.credit-transaction :$creditAccountList :selectedCreditAccountId="$creditAccountId" />
        </x-helpers.modal>
    @endif
</div>
