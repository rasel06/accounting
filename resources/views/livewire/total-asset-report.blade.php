<x-helpers.parts.content-panel>

    <x-slot name="heading">Total Asset Report</x-slot>

    <x-helpers.parts.data-table.control :reportMenu=true />


    {{-- {{ print_r($reportData) }}
    date
    {{ $this->reportFromDate }}
    {{ $this->reportToDate }}
    date --}}

    <x-helpers.parts.data-table.report-table>

        <table class="mb-4 w-full">

            <tbody class="bg-white">
                @if (isset($reportData['debit_transactions']) && count($reportData['debit_transactions']) > 0)
                    @php
                        $gorupTotal = 0;
                    @endphp

                    <tr class="bg-slate-500 rounded">
                        <td>Debit Transaction</td>
                        <td>Amount</td>
                    </tr>

                    @foreach ($reportData['debit_transactions'] as $debitTransaction)
                        <tr>
                            <td>{{ $debitTransaction->description }}</td>
                            <td><?php
                            $gorupTotal += $debitTransaction->total;
                            echo $debitTransaction->total;
                            ?>
                            </td>

                        </tr>
                    @endforeach
                    <tr class="bg-slate-400">
                        <td>Total Debit Transaction</td>
                        <td>{{ $gorupTotal }}</td>
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
