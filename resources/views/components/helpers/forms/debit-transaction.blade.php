@props(['paymentMethodList', 'selectedPaymentMethodId'])


<x-helpers.forms.panel wire:submit="create">
    <x-helpers.parts.select wire:model.change="payment_method_id" label="Payment Method" name="payment_method_id">
        @foreach ($paymentMethodList as $item)
            <option value="{{ $item->id }}" {{ $item->id == $selectedPaymentMethodId ? 'selected' : '' }}>
                {{ $item->name }} (<x-helpers.parts.data-table.status :status="$item->status" />)
            </option>
        @endforeach
    </x-helpers.parts.select>

    <x-helpers.parts.input wire:model="description" label="Description" name="description" />

    <div class="grid grid-cols-2 gap-4">
        <x-helpers.parts.input wire:model="invoice_number" label="Invoice Number" name="invoice_number" />
        <x-helpers.parts.input wire:model="invoice_date" type="date" label="Invoice Date" name="invoice_date" />

    </div>

    <div class="grid grid-cols-3 gap-4">
        <x-helpers.parts.input wire:model="number_of_unit" label="Number of Unit" name="number_of_unit" />
        <x-helpers.parts.input wire:model="unit_price" label="Unit Price" name="unit_price" />
        <x-helpers.parts.input wire:model="total" label="Total" name="total" />
    </div>

    <div class="grid grid-cols-2 gap-4">
        <x-helpers.parts.input wire:model="remarks" label="Remarks" name="remarks" />
        <x-helpers.parts.input wire:model="invoice_file" type="file" label="Invoice File" name="invoice_file" />
    </div>

</x-helpers.forms.panel>
