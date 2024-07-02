@props(['paymentMethodList', 'selectedPaymentMethodId'])


<x-helpers.forms.panel wire:submit="store">
    <x-helpers.parts.select wire:model="paymentMethodId" label="Payment Method" name="payment_method_id">
        @foreach ($paymentMethodList as $item)
            <option value="{{ $item->id }}" {{ $item->id == $selectedPaymentMethodId ? 'selected' : '' }}>
                {{ $item->name }} ({{ $item->status }})
            </option>
        @endforeach
    </x-helpers.parts.select>

    <x-helpers.parts.input name="description" />

    <div class="grid grid-cols-2 gap-4">
        <x-helpers.parts.input name="invoiceNumber" />
        <x-helpers.parts.input name="invoiceDate" type="date" />
    </div>

    <div class="grid grid-cols-3 gap-4">
        <x-helpers.parts.input name="numberOfUnit" :liveChange="true" />
        <x-helpers.parts.input name="unitPrice" :liveChange="true" />
        <x-helpers.parts.input name="total" :liveChange="true" />
    </div>

    <div class="grid grid-cols-2 gap-4">
        <x-helpers.parts.input name="remarks" />
        <x-helpers.parts.input name="invoiceFile" type="file" />
    </div>


</x-helpers.forms.panel>
