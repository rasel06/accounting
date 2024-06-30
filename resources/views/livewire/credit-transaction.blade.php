<div>
    <div class="w-full mx-auto px-4 bg-slate-300 rounded-lg ">
        <div class="flex flex-col items-stretch">
            <h1 class="text-xl font-bold text-cyan-500 py-2">Credit Transaction <span>::</span> </h1>
            <hr class="border-slate-500/40 ">
            <x-helpers.parts.data-table.control :showStatus="false">

                <select wire:model.change="creditAccountFilter"
                    class="border-gray-100 rounded ml-2 py-1 pr-8 text-gray-700 leading-tight focus:outline-none focus:bg-white focus:border-gray-300">
                    <option value="">Account</option>
                    @foreach ($creditAccountList as $creditAccount)
                        <option value="{{ $creditAccount->id }}">{{ $creditAccount->name }}</option>
                    @endforeach
                </select>




                {{-- <div date-rangepicker class="flex items-center">
                    <div class="relative">
                        <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                            <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true"
                                xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                                <path
                                    d="M20 4a2 2 0 0 0-2-2h-2V1a1 1 0 0 0-2 0v1h-3V1a1 1 0 0 0-2 0v1H6V1a1 1 0 0 0-2 0v1H2a2 2 0 0 0-2 2v2h20V4ZM0 18a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V8H0v10Zm5-8h10a1 1 0 0 1 0 2H5a1 1 0 0 1 0-2Z" />
                            </svg>
                        </div>
                        <input name="start" type="text"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full ps-10 p-2.5  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                            placeholder="Select date start">
                    </div>
                    <span class="mx-4 text-gray-500">to</span>
                    <div class="relative">
                        <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                            <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true"
                                xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                                <path
                                    d="M20 4a2 2 0 0 0-2-2h-2V1a1 1 0 0 0-2 0v1h-3V1a1 1 0 0 0-2 0v1H6V1a1 1 0 0 0-2 0v1H2a2 2 0 0 0-2 2v2h20V4ZM0 18a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V8H0v10Zm5-8h10a1 1 0 0 1 0 2H5a1 1 0 0 1 0-2Z" />
                            </svg>
                        </div>
                        <input name="end" type="text"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full ps-10 p-2.5  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                            placeholder="Select date end">
                    </div>
                </div> --}}



                {{-- <div class="justify-between ml-2 py-1 pr-8 flex">
                    <input type="date" placeholder="From Date"
                        class="bg-gray-100 appearance-none border-2 border-gray-100 rounded w-1/2 py-1 px-2 text-gray-700 leading-tight focus:outline-none focus:bg-white focus:border-gray-300">
                    <input type="date" placeholder="To Date"
                        class="bg-gray-100 appearance-none border-2 border-gray-100 rounded w-1/2 py-1 px-2 text-gray-700 leading-tight focus:outline-none focus:bg-white focus:border-gray-300">
                </div> --}}

            </x-helpers.parts.data-table.control>
            <x-helpers.parts.data-table.credit-transaction-table :tableItems="$tableDataList" :$limitFilter :$tableFields />
        </div>
    </div>

    @if ($showModal)
        <x-helpers.modal :id>
            <x-helpers.forms.credit-transaction :$creditAccountList :selectedCreditAccountId="$this->creditAccountId" />
        </x-helpers.modal>
    @endif
</div>
