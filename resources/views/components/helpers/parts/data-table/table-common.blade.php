@props(['tableItems', 'limitFilter', 'tableFields' => []])



{{-- -my-2 py-2 sm:-mx-6 sm:px-6 lg:-mx-8 lg:px-8  --}}
<div class="pb-3">


    <div class="align-middle inline-block w-full shadow overflow-x-auto sm:rounded-lg border-b border-gray-200 ">
        <table class="min-w-full text-slate-900 ">
            <thead>
                <tr
                    class="bg-slate-500 border-b font-extrabold border-gray-200 text-xs leading-4 text-gray-100 uppercase tracking-wider">

                    <x-helpers.parts.data-table.th class="text-left">
                        Serial
                    </x-helpers.parts.data-table.th>
                    @foreach ($tableFields as $key => $value)
                        <x-helpers.parts.data-table.th class="text-left">
                            {{ $value }}
                        </x-helpers.parts.data-table.th>
                    @endforeach
                    <x-helpers.parts.data-table.th class="text-right">
                        Action
                    </x-helpers.parts.data-table.th>
                </tr>
            </thead>
            <tbody class="bg-white">
                @foreach ($tableItems as $item)
                    <tr class="text-gray-600 bg-slate-300/30 odd:bg-white">

                        <x-helpers.parts.data-table.td>
                            <div class="text-sm leading-5 ">
                                {{ $loop->iteration }}
                            </div>
                        </x-helpers.parts.data-table.td>

                        @foreach ($tableFields as $key => $value)
                            <x-helpers.parts.data-table.td class="text-left">
                                {{ $item->{$key} }}
                            </x-helpers.parts.data-table.td>
                        @endforeach

                        <x-helpers.parts.data-table.td class="py-1 text-sm  flex justify-end text-center">
                            <x-helpers.parts.data-table.actions :id="$item->id" />
                        </x-helpers.parts.data-table.td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    @if ($limitFilter != '')
        <div class="pt-2 ">
            {{ $tableItems->links() }}
        </div>
    @endif
</div>
