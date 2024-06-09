<div>

    <div class="w-full h-fit">
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

                    </div>
                    <div class="flex items-center py-2">
                        <a href=""
                            class="inline-block px-4 py-1 border border-transparent text-sm leading-5 font-medium rounded-md text-white bg-cyan-600 hover:bg-cyan-500 focus:outline-none focus:shadow-outline">
                            Create new page
                        </a>
                    </div>
                </div>
                <div class="-my-2 py-2 sm:-mx-6 sm:px-6 lg:-mx-8 lg:px-8">
                    <div
                        class="align-middle inline-block w-full shadow overflow-x-auto sm:rounded-lg border-b border-gray-200">
                        <table class="min-w-full text-slate-900">
                            <!-- HEAD start -->
                            <thead>

                                <tr
                                    class="bg-gray-200 border-b font-bold border-gray-200 text-xs leading-4 text-gray-500 uppercase tracking-wider">

                                    <th class="px-6 py-2 text-left font-medium">
                                        Serial
                                    </th>
                                    <th class="px-6 py-2 text-left font-medium">
                                        Method Name
                                    </th>
                                    <th class="px-6 py-2 text-left font-medium">
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
                                        <td
                                            class="px-6 py-1 whitespace-no-wrap text-right border-b border-gray-200 text-sm leading-5 font-medium">

                                            {{-- <button type="button" class="inline-block text-cyan-400 hover:text-gray-700">
                                                <svg class="inline-block h-6 w-6 fill-current" viewBox="0 0 24 24">
                                                    <path
                                                        d="M12 6a2 2 0 110-4 2 2 0 010 4zm0 8a2 2 0 110-4 2 2 0 010 4zm-2 6a2 2 0 104 0 2 2 0 00-4 0z" />
                                                </svg>
                                            </button> --}}

                                        </td>
                                    </tr>
                                @endforeach

                            </tbody>
                            <!-- BODY end -->
                        </table>



                    </div>

                    <div class="px-4 py-2 ">
                        {{ $paymentMethods->onEachSide(3)->links() }}
                        {{-- {{ $paymentMethods->links() }} --}}
                    </div>

                </div>
            </div>
        </div>
    </div>


</div>
