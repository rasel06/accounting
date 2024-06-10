<div class="">

    {{-- <livewire:parts.helper.modal  /> --}}


    <div class="w-full h-fit ">
        <div class="max-w-7xl mx-auto sm:px-4 lg:px-3 bg-slate-300 rounded-lg ">
            <div class="flex flex-col">
                <div class="py-1 flex flex-wrap flex-grow justify-between">
                    <div class="flex items-center py-2">
                        <input wire:model.live="paymentName"
                            class="bg-gray-100 appearance-none border-2 border-gray-100 rounded w-full py-1 px-2 text-gray-700 leading-tight focus:outline-none focus:bg-white focus:border-gray-300"
                            id="inline-search" type="text" placeholder="Search">

                        <select wire:model.change="status"
                            class="border-gray-100 rounded ml-4 py-1 px-8 text-gray-700 leading-tight focus:outline-none focus:bg-white focus:border-gray-300">
                            <option value="">All</option>
                            <option value="active">Active</option>
                            <option value="inactive">In Active</option>
                        </select>

                        <span>{{ $id }}</span>

                    </div>

                    <div class="flex items-center py-2">
                        <button wire:click="create"
                            class="inline-block px-4 py-1 border border-transparent text-sm leading-5 font-medium rounded-md text-white bg-cyan-600 hover:bg-cyan-500 focus:outline-none focus:shadow-outline">
                            Create new page
                        </button>
                    </div>
                </div>
                <div class="-my-2 py-2 sm:-mx-6 sm:px-6 lg:-mx-8 lg:px-8">
                    <div
                        class="align-middle inline-block w-full shadow overflow-x-auto sm:rounded-lg border-b border-gray-200">
                        <table class="min-w-full text-slate-900">
                            <!-- HEAD start -->
                            <thead>

                                <tr
                                    class="bg-slate-500 border-b font-extrabold border-gray-200 text-xs leading-4 text-gray-100 uppercase tracking-wider">

                                    <th class="px-6 py-2 text-left font-medium">
                                        Serial
                                    </th>
                                    <th class="px-6 py-2 text-left font-medium">
                                        Method Name
                                    </th>
                                    <th class="px-6 py-2 text-center font-medium">
                                        Status
                                    </th>
                                    <th class="px-6 py-2 text-right font-medium">
                                        Action
                                    </th>
                                </tr>
                            </thead>
                            <!-- HEAD end -->
                            <!-- BODY start -->
                            <tbody class="bg-white">
                                @foreach ($paymentMethods as $paymentMethod)
                                    <tr class="text-gray-600 bg-slate-300/30 odd:bg-white">
                                        <td class="px-6 py-1 whitespace-no-wrap border-b border-gray-200">
                                            <div class="text-sm leading-5 ">
                                                {{ $loop->iteration }}
                                            </div>
                                        </td>

                                        <td class="px-6 py-1 whitespace-no-wrap border-b border-gray-200">
                                            {{ $paymentMethod->name }}
                                        </td>
                                        <td
                                            class="px-6 py-1 whitespace-no-wrap border-b text-center border-gray-200 text-sm leading-5 text-gray-500">
                                            <span
                                                class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $paymentMethod->status == 'active' ? 'bg-green-300 text-green-800' : 'bg-slate-300 text-slate-500' }} ">
                                                {{ $paymentMethod->status }}
                                            </span>

                                        </td>
                                        <td class="py-1 text-center border-b border-gray-200 text-sm  font-medium pr-3">


                                            <div class="flex gap-2 justify-end">
                                                <button class="" wire:click="details({{ $paymentMethod->id }})">
                                                    <span class="material-symbols-outlined">description</span>
                                                </button>
                                                <button class="text-green-600/60 hover:text-cyan-600"
                                                    wire:click="edit({{ $paymentMethod->id }})">
                                                    <span class="material-symbols-outlined">edit</span>
                                                </button>
                                                <button class="text-rose-600/60 hover:text-cyan-600"
                                                    wire:click="delete({{ $paymentMethod->id }})">
                                                    <span class="material-symbols-outlined">delete</span>
                                                </button>
                                            </div>

                                        </td>
                                    </tr>
                                @endforeach

                            </tbody>
                            <!-- BODY end -->
                        </table>



                    </div>

                    <div class="px-4 py-2 ">
                        {{ $paymentMethods->onEachSide(2)->links() }}
                        {{-- {{ $paymentMethods->links() }} --}}
                    </div>

                </div>
            </div>
        </div>

        {{-- Modal for create new item --}}

        @if ($showModal)
            <x-helpers.modal header="Create New Payment Method" :$userId>

            </x-helpers.modal>
        @endif


    </div>




</div>
