<x-helpers.parts.content-panel>

    <x-slot name="heading">Total Asset Report</x-slot>

    <x-helpers.parts.data-table.control :reportMenu=true />


    {{-- {{ print_r($reportData) }}
    date
    {{ $this->reportFromDate }}
    {{ $this->reportToDate }}
    date --}}

    <x-helpers.parts.data-table.report-table>
        <table class=" w-full text-md ">

            <thead>
                <tr class="bg-slate-500 rounded text-white leading-6 font-extrabold">
                    <td class="spa">
                        <span class="pl-4">Asset type</span>
                    </td>
                    <td class="text-right pr-6">
                        <span class="pl-4">Amount</span>
                    </td>
                </tr>
            </thead>

            <tbody class="bg-white">
                @php
                    $reportItemExist =
                        isset($this->reportData['othersData']) && count($this->reportData['othersData']) > 0;

                    $cashAmount = $this->reportData['totalCredit'] - $this->reportData['totalDebit'];
                    $othersTotal = 0;
                @endphp

                @if ($cashAmount != 0)
                    <tr class="rounded leading-6  bg-cyan-300/30 odd:bg-white">
                        <td class="spa">
                            <span class="pl-4">Cash</span>
                        </td>
                        <td class="text-right pr-6">
                            <span class="pl-4 {{ $cashAmount > 0 ? 'text-slate-500' : ' text-rose-500' }}">
                                {{ number_format($cashAmount, 2, '.', ',') }}
                            </span>
                        </td>
                    </tr>
                @endif

                @if ($reportItemExist)
                    @foreach ($this->reportData['othersData'] as $reportItem)
                        <tr class="rounded leading-6  bg-cyan-300/20 odd:bg-white">
                            <td class="spa">
                                <span class="pl-4">{{ $reportItem->name }}</span>
                            </td>
                            <td class="text-right pr-6">
                                <span class="pl-4 {{ $reportItem->amount > 0 ? 'text-slate-500' : ' text-rose-500' }}">
                                    @php
                                        $othersTotal += $reportItem->amount;
                                    @endphp
                                    {{ number_format($reportItem->amount, 2, '.', ',') }}
                                </span>
                            </td>
                        </tr>
                    @endforeach
                @endif
            </tbody>


            <tfoot>
                <tr class="rounded leading-6  bg-slate-500  text-white font-extrabold">
                    <td class="text-left">
                        <span class="pl-4">Inword : </span>
                        <span class="pl-4">
                            @php
                                $total = $cashAmount + $othersTotal;
                            @endphp
                            @if ($total != 0)
                                {{ $this->convertToWords($total) }}
                            @endif
                        </span>
                    </td>
                    <td class="text-right pr-6">
                        <span class="pl-4">Total</span>
                        <span class="pl-4 {{ $total > 0 ? 'text-green-500' : ' text-rose-500' }}">
                            {{ number_format($total, 2, '.', ',') }}
                        </span>
                    </td>
                </tr>
            </tfoot>


        </table>
    </x-helpers.parts.data-table.report-table>




    {{-- @if (isset($reportData['debit_transactions']) && count($reportData['debit_transactions']) > 0)
        @foreach ($reportData['debit_transactions'] as $debitTransaction)
            {{ print_r($debitTransaction) }}
        @endforeach
    @endif --}}


    {{-- <x-helpers.parts.data-table.store-table :tableItems="$storeList" :$limitFilter :$tableFields /> --}}


</x-helpers.parts.content-panel>
