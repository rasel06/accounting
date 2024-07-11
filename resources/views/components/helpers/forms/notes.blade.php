@props(['accountList', 'selectedAccountId', 'storeList', 'selectedStoreId'])


<x-helpers.forms.panel wire:submit="store">

    <div class="grid grid-cols-4 gap-4">
        <div class="col-span-3">
            <x-helpers.parts.input name="title" />
        </div>

        <div class="col-span-1">
            <div class="mb-2 ">
                <label for="is_important" class="block text-sm font-medium leading-6 text-gray-600">Important
                    ?</label>
                <div class="relative mt-1 rounded-md shadow-sm flex justify-evenly p-2" x-data="{ isChecked: @entangle('isImportant') }"
                    x-init="$watch('$wire.isImportant', value => isChecked = value)">
                    <input @change="$wire.set('isImportant', isChecked ? 1 : 0)" wire:model="isImportant"
                        :checked="isChecked ? true : false" :value="isChecked ? 1 : 0" x-model="isChecked"
                        name="is_important" type="checkbox" class="min-h-5 min-w-5 rounded-full">
                </div>
            </div>
        </div>
    </div>


    <div class="grid grid-cols-2 gap-4">
        <x-helpers.parts.select wire:model="storeId" label="Store" name="store_id">
            <option value="">Select Store</option>
            @foreach ($storeList as $store)
                <option value="{{ $store->id }}" {{ $store->id == $selectedStoreId ? 'selected' : '' }}>
                    {{ $store->name }} -> {{ $store->location->name }}
                </option>
            @endforeach
        </x-helpers.parts.select>

        <x-helpers.parts.select wire:model="accountId" label="Account" name="account_id">
            <option value="">Select Account</option>
            @foreach ($accountList as $account)
                <option value="{{ $account->id }}" {{ $account->id == $selectedAccountId ? 'selected' : '' }}>
                    {{ $account->name }}
                </option>
            @endforeach
        </x-helpers.parts.select>
    </div>

    <div class="grid grid-cols-2 gap-4">
        <x-helpers.parts.input name="noteDate" type="date" value="{{ date('Y-m-d') }}" max="{{ date('Y-m-d') }}" />

        <x-helpers.parts.input name="remarks" />
    </div>

    {{-- <x-helpers.parts.input name="details" /> --}}



    <div class="mb-2" wire:ignore>
        <label for="details" class="block text-sm font-medium leading-6 text-gray-600">Details</label>
        <div class="relative mt-1 rounded-md shadow-sm">

            {{-- <div id="editor"> --}}

            {{-- <div id="details">{!! $this->details !!}</div> --}}

            <textarea wire:model="details" name="details" id="details" input="details"
                class="summernote block w-full rounded-md border-0 py-1.5 text-gray-900 ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-purple-300 sm:text-sm sm:leading-6">
                {!! $this->details !!}
            </textarea>


        </div>
        <div class="text-xs text-rose-500 mt-1">
            {{-- @error($name)
            {{ $message }}
        @enderror --}}
        </div>
    </div>



</x-helpers.forms.panel>
