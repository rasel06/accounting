<x-helpers.parts.content-panel>
    <x-slot name="heading">Notes</x-slot>

    <x-helpers.parts.data-table.control :showStatus="false">
        <select wire:model.change="paymentMethodFilter"
            class="border-gray-100 rounded ml-2 py-1 pr-8 text-gray-700 leading-tight focus:outline-none focus:bg-white focus:border-gray-300">
            <option value="">Account</option>
            @foreach ($accountList as $paymentMethod)
                <option value="{{ $paymentMethod->id }}">{{ $paymentMethod->name }}</option>
            @endforeach
        </select>
    </x-helpers.parts.data-table.control>

    <x-helpers.parts.data-table.notes-table :tableItems="$debitTransactionList" :$limitFilter :$tableFields />

    <x-slot name="modal">
        <x-helpers.modal :id>
            <x-helpers.forms.notes :$accountList :selectedAccountId="$accountId" :$storeList :selectedStoreId="$storeId" :$assetTypeList
                :selectedAssetTypeId="$assetTypeId" />
        </x-helpers.modal>
    </x-slot>

</x-helpers.parts.content-panel>
