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
    </x-helpers.parts.data-table.control>

    <x-helpers.parts.data-table.credit-transaction-table :tableItems="$tableDataList" :$limitFilter :$tableFields />

    <x-slot name="modal">
        <x-helpers.modal :id>
            <x-helpers.forms.credit-transaction :$creditAccountList :selectedCreditAccountId="$this->creditAccountId" />
        </x-helpers.modal>
    </x-slot>

</x-helpers.parts.content-panel>
