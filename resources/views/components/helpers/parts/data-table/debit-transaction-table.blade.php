@props(['tableItems', 'limitFilter', 'tableFields' => []])


@php
    $totalAmount = 0;
@endphp

{{-- -my-2 py-2 sm:-mx-6 sm:px-6 lg:-mx-8 lg:px-8  --}}
<div class="pb-3 ">

    <div class="align-middle inline-block w-full shadow overflow-x-auto sm:rounded-lg border-b border-gray-200 ">
        <table class="min-w-full text-slate-900 text-sm">
            <x-helpers.parts.data-table.thead :$tableFields />
            <tbody class="bg-white ">
                @if ($tableItems)
                    @foreach ($tableItems as $item)
                        <tr class="text-gray-600 bg-slate-300/30 odd:bg-white">

                            <x-helpers.parts.data-table.td>
                                {{ $loop->iteration }}
                            </x-helpers.parts.data-table.td>

                            <x-helpers.parts.data-table.td class="text-left">
                                {{ $item->store ? $item->store->name . ' (' . $item->store->location->name . ')' : '' }}
                            </x-helpers.parts.data-table.td>

                            <x-helpers.parts.data-table.td class="text-left">
                                {{ $item->paymentMethod->name }}
                            </x-helpers.parts.data-table.td>

                            <x-helpers.parts.data-table.td class="text-left">
                                {{ $item->description }}
                            </x-helpers.parts.data-table.td>

                            <x-helpers.parts.data-table.td class="text-left">
                                {{ $item->invoice_number }}
                            </x-helpers.parts.data-table.td>
                            <x-helpers.parts.data-table.td class="text-left">
                                {{ $this->convertDate($item->invoice_date) }}
                            </x-helpers.parts.data-table.td>
                            <x-helpers.parts.data-table.td class="text-center">
                                <x-helpers.parts.image :file="$item->invoice_file" />
                            </x-helpers.parts.data-table.td>
                            <x-helpers.parts.data-table.td class="text-left">
                                {{ $item->number_of_unit }}
                            </x-helpers.parts.data-table.td>
                            <x-helpers.parts.data-table.td class="text-right">
                                {{ $item->unit_price }}
                            </x-helpers.parts.data-table.td>
                            <x-helpers.parts.data-table.td class="text-right">
                                @php
                                    $totalAmount += $item->total;
                                    echo number_format($item->total, 2, '.', ',');
                                @endphp
                            </x-helpers.parts.data-table.td>
                            <x-helpers.parts.data-table.td class="text-left">
                                {{ $item->remarks }}
                            </x-helpers.parts.data-table.td>
                            <x-helpers.parts.data-table.td
                                class="py-1 text-sm  flex justify-end text-center print:hidden">
                                <x-helpers.parts.data-table.actions :id="$item->id" />
                            </x-helpers.parts.data-table.td>
                        </tr>
                    @endforeach
                @endif

            </tbody>

            <x-helpers.parts.data-table.table-footer class=" text-xs">
                <x-helpers.parts.data-table.th colspan="8" class="text-left">
                    In Word : {{ $this->convertToWords($totalAmount) }}
                </x-helpers.parts.data-table.th>

                <x-helpers.parts.data-table.th class="text-right ">Total</x-helpers.parts.data-table.th>
                <x-helpers.parts.data-table.th class="text-left">
                    {{ number_format($totalAmount, 2, '.', ',') }}
                </x-helpers.parts.data-table.th>
                <x-helpers.parts.data-table.th colspan="3" class="text-right" />
            </x-helpers.parts.data-table.table-footer>
        </table>
    </div>

    @if ($limitFilter != '')
        <div class="pt-2 ">
            {{ $tableItems->links() }}
        </div>
    @endif
</div>
