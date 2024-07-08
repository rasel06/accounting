@props(['accountList', 'selectedAccountId', 'storeList', 'selectedStoreId', 'assetTypeList', 'selectedAssetTypeId'])


<x-helpers.forms.panel wire:submit="store">
    <x-helpers.parts.input name="description" />

    <div class="grid grid-cols-2 gap-4">

        <x-helpers.parts.select wire:model="storeId" label="Store" name="store_id">
            @foreach ($storeList as $store)
                <option value="{{ $store->id }}" {{ $store->id == $selectedStoreId ? 'selected' : '' }}>
                    {{ $store->name }} -> {{ $store->location->name }}
                </option>
            @endforeach
        </x-helpers.parts.select>

        <x-helpers.parts.select wire:model="accountId" label="Account" name="account_id">
            @foreach ($accountList as $account)
                <option value="{{ $account->id }}" {{ $account->id == $selectedAccountId ? 'selected' : '' }}>
                    {{ $account->name }}
                </option>
            @endforeach
        </x-helpers.parts.select>
    </div>

    <div class="grid grid-cols-2 gap-4">
        <x-helpers.parts.select wire:model="assetTypeId" label="Asset Type" name="asset_type_id">
            @foreach ($assetTypeList as $assetType)
                <option value="{{ $assetType->id }}" {{ $assetType->id == $selectedAssetTypeId ? 'selected' : '' }}>
                    {{ $assetType->name }}
                </option>
            @endforeach
        </x-helpers.parts.select>
        <x-helpers.parts.input name="date" type="date" />

    </div>


    <div class="grid grid-cols-2 gap-4">
        <x-helpers.parts.input name="amount" />
        <x-helpers.parts.input name="remarks" />
    </div>


</x-helpers.forms.panel>
