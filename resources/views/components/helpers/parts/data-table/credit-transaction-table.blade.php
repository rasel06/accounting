@props(['tableItems', 'limitFilter', 'tableFields' => [], 'showTotal' => false])

@php
    $totalAmount = 0;
@endphp

{{-- -my-2 py-2 sm:-mx-6 sm:px-6 lg:-mx-8 lg:px-8  --}}
<div class="pb-3 ">
    <div class="align-middle inline-block w-full shadow overflow-x-auto sm:rounded-lg">
        @if ($tableItems)
            <table class="min-w-full text-slate-900 text-sm ">
                <thead>
                    <tr class="bg-slate-500 font-extrabold border-gray-200 text-gray-100 uppercase text-xs ">
                        <x-helpers.parts.data-table.th class="text-left ">
                            Serial
                        </x-helpers.parts.data-table.th>

                        <x-helpers.parts.data-table.table-header :$tableFields />

                        <x-helpers.parts.data-table.th class="text-right print:hidden">
                            Action
                        </x-helpers.parts.data-table.th>
                    </tr>
                </thead>
                <tbody class="bg-white ">
                    @foreach ($tableItems as $item)
                        <tr class="text-gray-600 bg-slate-300/30 odd:bg-white">
                            <x-helpers.parts.data-table.td>
                                {{ $loop->iteration }}
                            </x-helpers.parts.data-table.td>

                            <x-helpers.parts.data-table.td class="text-left">
                                {{ $item->creditAccount->name }}
                            </x-helpers.parts.data-table.td>

                            <x-helpers.parts.data-table.td>
                                {{ $item->description }}
                            </x-helpers.parts.data-table.td>

                            <x-helpers.parts.data-table.td>
                                {{ $item->invoice_number }}
                            </x-helpers.parts.data-table.td>

                            <x-helpers.parts.data-table.td>
                                {{ $this->convertDate($item->invoice_date) }}
                            </x-helpers.parts.data-table.td>

                            <x-helpers.parts.data-table.td class="text-center">
                                <x-helpers.parts.image :file="$item->invoice_file" />
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

                            <x-helpers.parts.data-table.td
                                class="py-1 text-sm  flex justify-end text-center print:hidden">
                                <x-helpers.parts.data-table.actions :id="$item->id" :smallIcon="true" />
                            </x-helpers.parts.data-table.td>
                        </tr>
                    @endforeach
                </tbody>

                <x-helpers.parts.data-table.table-footer class="">
                    <x-helpers.parts.data-table.th colspan="5" class="text-left text-xs">
                        In Word : {{ $this->convertToWords($totalAmount) }}
                    </x-helpers.parts.data-table.th>
                    <x-helpers.parts.data-table.th class="text-right text-xs">Total</x-helpers.parts.data-table.th>
                    <x-helpers.parts.data-table.th class="text-left text-xs">
                        {{ number_format($totalAmount, 2, '.', ',') }}
                    </x-helpers.parts.data-table.th>
                    <x-helpers.parts.data-table.th colspan="3" class="text-right" />
                </x-helpers.parts.data-table.table-footer>

            </table>
        @endif

    </div>

    @if ($limitFilter != '')
        <div class="pt-2 ">
            {{ $tableItems->links() }}
        </div>
    @endif
</div>
