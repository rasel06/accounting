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
                                {{ $item->title }}
                            </x-helpers.parts.data-table.td>

                            <x-helpers.parts.data-table.td class="text-left">
                                {{ $item->store ? $item->store->name . ' (' . $item->store->location->name . ')' : '' }}
                            </x-helpers.parts.data-table.td>

                            <x-helpers.parts.data-table.td class="text-left">
                                {{ $item->account ? $item->account->name : '' }}
                            </x-helpers.parts.data-table.td>


                            <x-helpers.parts.data-table.td class="text-center ">
                                @if ($item->is_important == 1)
                                    <div class="w-full h-full flex items-center justify-center content-center">
                                        <div
                                            class="size-6 bg-green-500 flex justify-center items-center content-center rounded-full">
                                            <span class="material-symbols-outlined text-white ">
                                                {{ $item->is_important == 1 ? 'done_all' : '' }}
                                            </span>
                                        </div>
                                    </div>
                                @endif
                            </x-helpers.parts.data-table.td>

                            <x-helpers.parts.data-table.td class="text-left">
                                {{ $this->convertDate($item->note_date) }}
                            </x-helpers.parts.data-table.td>

                            <x-helpers.parts.data-table.td class="text-right">
                                {!! $item->details !!}
                            </x-helpers.parts.data-table.td>
                            <x-helpers.parts.data-table.td class="text-right">
                                {{ $item->remarks }}
                            </x-helpers.parts.data-table.td>
                            <x-helpers.parts.data-table.td class="text-center print:hidden">
                                <x-helpers.parts.data-table.actions :id="$item->id" />
                            </x-helpers.parts.data-table.td>
                        </tr>
                    @endforeach
                @endif

            </tbody>


        </table>
    </div>

    @if ($limitFilter != '')
        <div class="pt-2 ">
            {{ $tableItems->links() }}
        </div>
    @endif
</div>
