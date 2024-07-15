<x-helpers.parts.content-panel>
    <x-slot name="heading">Credit Transaction</x-slot>

    <x-helpers.parts.data-table.control :showStatus="false">
        <select wire:model.change="creditAccountFilter"
            class="border-gray-100 rounded ml-2 py-1 pr-8 text-gray-700 leading-tight focus:outline-none focus:bg-white focus:border-gray-300">
            <option value="">Account</option>
            @foreach ($creditAccountList as $creditAccount)
                <option value="{{ $creditAccount->id }}">{{ $creditAccount->name }}</option>
            @endforeach
        </select>

        <x-helpers.parts.date-range name="creditTxn" />

        {{-- <div class="ml-2 flex gap-2">
            <input type="date" placeholder="From Date" value=""
                class="block w-1/2 rounded-md border-0 py-1 text-gray-900 ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-purple-300 sm:text-sm sm:leading-6">
            <input type="date"
                class="block w-1/2 rounded-md border-0 py-1 text-gray-900 ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-purple-300 sm:text-sm sm:leading-6">

        </div> --}}

    </x-helpers.parts.data-table.control>

    <x-helpers.parts.data-table.credit-transaction-table :tableItems="$tableDataList" :$limitFilter :$tableFields />

    <x-slot name="modal">
        <x-helpers.modal :id>
            <x-helpers.forms.credit-transaction :$creditAccountList :selectedCreditAccountId="$this->creditAccountId" />
        </x-helpers.modal>
    </x-slot>

</x-helpers.parts.content-panel>
