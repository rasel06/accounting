<x-helpers.parts.content-panel>

    <x-slot name="heading">Total Asset Report</x-slot>

    <x-helpers.parts.data-table.control :reportMenu=true />


    {{-- {{ print_r($reportData) }}
    date
    {{ $this->reportFromDate }}
    {{ $this->reportToDate }}
    date --}}

    <x-helpers.parts.data-table.report-table>

        <table class="mb-4 w-full text-md ">

            <tbody class="bg-white">
                @if (isset($reportData['debit_transactions']) && count($reportData['debit_transactions']) > 0)
                    @php
                        $gorupTotal = 0;
                    @endphp
                    <tr class="bg-slate-500 rounded text-white leading-6">
                        <td class="spa">
                            <span class="pl-4">Debit Transaction</span>
                        </td>
                        <td>
                            <span class="pl-4">Amount</span>
                        </td>
                    </tr>
                    @foreach ($reportData['debit_transactions'] as $debitTransaction)
                        <tr class="leading-6 bg-slate-300/30 odd:bg-white">
                            <td>
                                <span class="pl-4">{{ $debitTransaction->description }}</span>
                            </td>
                            <td>
                                @php
                                    $gorupTotal += $debitTransaction->total;
                                @endphp
                                <span class="pl-4">{{ $debitTransaction->total }}</span>
                            </td>
                        </tr>
                    @endforeach
                    <tr class="bg-slate-400 leading-6">
                        <td>
                            <span class="pl-4">Total Debit Transaction</span>
                        </td>
                        <td>
                            <span class="pl-4">
                                {{ $gorupTotal }}
                            </span>
                        </td>
                    </tr>
                @endif
            </tbody>
        </table>
    </x-helpers.parts.data-table.report-table>




    {{-- @if (isset($reportData['debit_transactions']) && count($reportData['debit_transactions']) > 0)
        @foreach ($reportData['debit_transactions'] as $debitTransaction)
            {{ print_r($debitTransaction) }}
        @endforeach
    @endif --}}


    {{-- <x-helpers.parts.data-table.store-table :tableItems="$storeList" :$limitFilter :$tableFields /> --}}


</x-helpers.parts.content-panel>
