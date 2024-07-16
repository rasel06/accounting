@props(['tableItems', 'limitFilter', 'tableFields' => []])


@php
    $totalAmount = 0;
@endphp

{{-- -my-2 py-2 sm:-mx-6 sm:px-6 lg:-mx-8 lg:px-8  --}}
<div class="pb-3 ">

    <div class="align-middle inline-block w-full shadow overflow-x-auto sm:rounded-lg border-b border-gray-200 ">
        <table class="min-w-full text-slate-900 text-sm">
            <thead>
                <tr
                    class="bg-slate-500 border-b font-extrabold border-gray-200 text-xs leading-4 text-gray-100 uppercase tracking-wider">
                    <x-helpers.parts.data-table.th class="text-left">
                        Serial
                    </x-helpers.parts.data-table.th>

                    <x-helpers.parts.data-table.table-header :$tableFields />

                    <x-helpers.parts.data-table.th class="text-right">
                        Action
                    </x-helpers.parts.data-table.th>
                </tr>
            </thead>
            <tbody class="bg-white ">
                @if ($tableItems)
                    @foreach ($tableItems as $item)
                        <tr class="text-gray-600 bg-slate-300/30 odd:bg-white">

                            <x-helpers.parts.data-table.td>
                                {{ $loop->iteration }}
                            </x-helpers.parts.data-table.td>
                            <x-helpers.parts.data-table.td class="text-left">
                                {{ $item->description }}
                            </x-helpers.parts.data-table.td>

                            <x-helpers.parts.data-table.td class="text-left">
                                {{ $item->store ? $item->store->name . ' (' . $item->store->location->name . ')' : '' }}
                            </x-helpers.parts.data-table.td>

                            <x-helpers.parts.data-table.td class="text-left">
                                {{ $item->assetType->name }}
                            </x-helpers.parts.data-table.td>

                            <x-helpers.parts.data-table.td class="text-left">
                                {{ $item->account->name }}
                            </x-helpers.parts.data-table.td>

                            <x-helpers.parts.data-table.td class="text-left">
                                {{ $this->convertDate($item->txn_date) }}
                            </x-helpers.parts.data-table.td>

                            <x-helpers.parts.data-table.td>
                                @php
                                    $totalAmount += $item->amount;
                                    echo number_format($item->amount, 2, '.', ',');
                                @endphp
                            </x-helpers.parts.data-table.td>
                            <x-helpers.parts.data-table.td>
                                {{ $item->remarks }}
                            </x-helpers.parts.data-table.td>
                            <x-helpers.parts.data-table.td class="py-1 text-sm  flex justify-end text-center">
                                <x-helpers.parts.data-table.actions :id="$item->id" />
                            </x-helpers.parts.data-table.td>
                        </tr>
                    @endforeach
                @endif

            </tbody>

            <x-helpers.parts.data-table.table-footer class=" text-xs">
                <x-helpers.parts.data-table.th colspan="5" class="text-left ">
                    In Word : {{ $totalAmount > 0 ? $this->convertToWords($totalAmount) : '' }}
                </x-helpers.parts.data-table.th>

                <x-helpers.parts.data-table.th class="text-right ">Total</x-helpers.parts.data-table.th>
                <x-helpers.parts.data-table.th class="text-left ">
                    {{ $totalAmount > 0 ? number_format($totalAmount, 2, '.', ',') : '' }}
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
