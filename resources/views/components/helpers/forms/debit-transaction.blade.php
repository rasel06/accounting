@props(['paymentMethodList', 'selectedPaymentMethodId', 'storeList', 'selectedStoreId'])


<x-helpers.forms.panel wire:submit="store">
    <x-helpers.parts.input name="description" />
    <div class="grid grid-cols-2 gap-4">
        <x-helpers.parts.select wire:model="paymentMethodId" label="Payment Method" name="payment_method_id">
            @foreach ($paymentMethodList as $paymentMethod)
                <option value="{{ $paymentMethod->id }}"
                    {{ $paymentMethod->id == $selectedPaymentMethodId ? 'selected' : '' }}>
                    {{ $paymentMethod->name }}
                </option>
            @endforeach
        </x-helpers.parts.select>

        <x-helpers.parts.select wire:model="storeId" label="Store" name="stor_id">
            @foreach ($storeList as $store)
                <option value="{{ $store->id }}" {{ $store->id == $selectedStoreId ? 'selected' : '' }}>
                    {{ $store->name }} -> {{ $store->location->name }}
                </option>
            @endforeach
        </x-helpers.parts.select>
    </div>


    <div class="grid grid-cols-2 gap-4">
        <x-helpers.parts.input name="invoiceNumber" :fillAble="$this->id ? false : true" />

        {{ $this->id }}
        <x-helpers.parts.input name="invoiceDate" type="date" />
    </div>

    <div class="grid grid-cols-3 gap-4">
        <x-helpers.parts.input name="numberOfUnit" :liveChange="true" />
        <x-helpers.parts.input name="unitPrice" :liveChange="true" />
        <x-helpers.parts.input name="total" :liveChange="true" />
    </div>

    <div class="grid grid-cols-2 gap-4">
        <x-helpers.parts.input name="remarks" />
        {{-- <x-helpers.parts.input name="invoiceFile" type="file" /> --}}

        @if ($this->id == null)
            <x-helpers.parts.input name="invoiceFile" type="file" :defer="true" />
        @else
            <div class="grid {{ $this->invoiceFile ? 'grid-cols-2' : '' }} gap-4">
                <x-helpers.parts.input name="invoiceFile" type="file" :defer="true" />
                @if ($this->invoiceFile)
                    <x-helpers.parts.image :file="$this->invoiceFile" size="size-20" />
                @endif
            </div class="grid grid-cols-2 gap-4">
        @endif


    </div>


</x-helpers.forms.panel>
