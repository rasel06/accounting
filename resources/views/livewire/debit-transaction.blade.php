<x-helpers.parts.content-panel>
    <x-slot name="heading">
        Debit Transaction
    </x-slot>

    <x-helpers.parts.data-table.control :showStatus="false">
        <select wire:model.change="paymentMethodFilter"
            class="border-gray-100 rounded ml-2 py-1 pr-8 text-gray-700 leading-tight focus:outline-none focus:bg-white focus:border-gray-300">
            <option value="">Account</option>
            @foreach ($paymentMethodList as $paymentMethod)
                <option value="{{ $paymentMethod->id }}">{{ $paymentMethod->name }}</option>
            @endforeach
        </select>

        <x-helpers.parts.date-range name="debitTxn" />

    </x-helpers.parts.data-table.control>

    <x-helpers.parts.data-table.debit-transaction-table :tableItems="$debitTransactionList" :$limitFilter :$tableFields />

    <x-slot name="modal">
        <x-helpers.modal :id>
            <x-helpers.forms.debit-transaction :$paymentMethodList :selectedPaymentMethodId="$paymentMethodId" :$storeList :selectedStoreId="$storeId" />
        </x-helpers.modal>
    </x-slot>

</x-helpers.parts.content-panel>
