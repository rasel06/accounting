@props(['tableItems', 'limitFilter'])




<div class="-my-2 py-2 sm:-mx-6 sm:px-6 lg:-mx-8 lg:px-8 ">


    <div class="align-middle inline-block w-full shadow overflow-x-auto sm:rounded-lg border-b border-gray-200 ">
        <table class="min-w-full text-slate-900 ">
            <thead>
                <tr
                    class="bg-slate-500 border-b font-extrabold border-gray-200 text-xs leading-4 text-gray-100 uppercase tracking-wider">

                    <x-helpers.parts.data-table.th class="text-left">
                        Serial
                    </x-helpers.parts.data-table.th>
                    <x-helpers.parts.data-table.th class="text-left">
                        Method Name
                    </x-helpers.parts.data-table.th>
                    <x-helpers.parts.data-table.th class="text-center">
                        Status
                    </x-helpers.parts.data-table.th>
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

                        <x-helpers.parts.data-table.td>
                            {{ $item->name }}
                        </x-helpers.parts.data-table.td>

                        <x-helpers.parts.data-table.td class="text-center  text-sm leading-5 text-gray-500">
                            <span
                                class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $item->status == 'active' ? 'bg-green-300 text-green-800' : 'bg-slate-300 text-slate-500' }} ">
                                {{ $item->status }}
                            </span>
                        </x-helpers.parts.data-table.td>

                        <x-helpers.parts.data-table.td class="py-1 text-sm  flex justify-end text-center">

                            <div role="group" class="text-gray-600 flex">
                                <x-helpers.parts.data-table.button wire:click="details({{ $item }})"
                                    class="rounded-l-lg text-purple-600/60 ">
                                    <span class="material-symbols-outlined ">description</span>
                                </x-helpers.parts.data-table.button>

                                <x-helpers.parts.data-table.button wire:click="edit({{ $item }})"
                                    class="text-green-600/60 ">
                                    <span class="material-symbols-outlined ">edit</span>
                                </x-helpers.parts.data-table.button>

                                <x-helpers.parts.data-table.button wire:click="delete({{ $item }})"
                                    class="rounded-r-lg text-rose-600/60">
                                    <span class="material-symbols-outlined ">delete</span>
                                </x-helpers.parts.data-table.button>

                            </div>
                        </x-helpers.parts.data-table.td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    @if ($limitFilter != '')
        <div class="py-2 ">
            {{ $tableItems->links() }}
        </div>
    @endif
</div>
