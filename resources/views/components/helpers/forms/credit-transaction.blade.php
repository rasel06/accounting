@props(['creditAccountList', 'selectedCreditAccountId'])


<x-helpers.forms.panel wire:submit="{{ $this->id == null ? 'store' : 'update' }}">

    <x-helpers.parts.select wire:model="creditAccountId" label="Credit Acoount" name="credit_account_id">
        @foreach ($creditAccountList as $item)
            <option value="{{ $item->id }}" {{ $item->id == $selectedCreditAccountId ? 'selected' : '' }}>
                {{ $item->name }} ({{ $item->status }})
            </option>
        @endforeach
    </x-helpers.parts.select>

    <x-helpers.parts.input name="description" />

    <div class="grid grid-cols-2 gap-4">
        <x-helpers.parts.input name="invoiceNumber" placeholder="DBC500000" :upper="true" :fillAble="true" />
        <x-helpers.parts.input name="invoiceDate" type="date" />
    </div>

    <div class="grid grid-cols-2 gap-4">
        <x-helpers.parts.input name="amount" />
        <x-helpers.parts.input name="remarks" />
    </div>

    @if ($this->id == null)
        <x-helpers.parts.input name="invoiceFile" type="file" :defer="true" />
    @else
        <div class="grid grid-cols-2 gap-4">
            <x-helpers.parts.input name="invoiceFile" type="file" :defer="true" />
            <x-helpers.parts.image :file="$this->invoiceFile" size="size-20" />
        </div class="grid grid-cols-2 gap-4">
    @endif

</x-helpers.forms.panel>
