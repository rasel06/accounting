<x-helpers.parts.modal-content-panel>
    <x-slot name="heading">Notes</x-slot>

    <x-helpers.parts.data-table.control :showStatus="false">
        <select wire:model.change="paymentMethodFilter"
            class="border-gray-100 rounded ml-2 py-1 pr-8 text-gray-700 leading-tight focus:outline-none focus:bg-white focus:border-gray-300">
            <option value="">Account</option>
            @foreach ($accountList as $paymentMethod)
                <option value="{{ $paymentMethod->id }}">{{ $paymentMethod->name }}</option>
            @endforeach
        </select>
    </x-helpers.parts.data-table.control>

    <x-helpers.parts.data-table.notes-table :tableItems="$debitTransactionList" :$limitFilter :$tableFields />


    {{-- <x-slot name="modal">
        <x-helpers.modal :id>
            <x-helpers.forms.notes :$accountList :selectedAccountId="$accountId" :$storeList :selectedStoreId="$storeId" />
        </x-helpers.modal>
    </x-slot> --}}

    {{-- https://codepen.io/natedog213/pen/eYgpVjL?editors=1010 --}}

    <div x-data="{ open: $wire.showModal }" x-init="$watch('$wire.showModal', value => open = value)">
        <h1 x-show="open" x-text="open"></h1>
        <div x-show="open"
            class="font-sans antialiased fixed bottom-0 inset-x-0 px-4 pb-4 sm:inset-0 sm:flex sm:items-center sm:justify-center">
            <div x-show="open" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0"
                x-transition:enter-end="opacity-100" x-transition:leave="ease-in duration-200"
                x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
                class="fixed inset-0 transition-opacity">
                <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
            </div>

            <div x-show="open" x-transition:enter="ease-out duration-300"
                x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                x-transition:leave="ease-in duration-200"
                x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                class="bg-rose-200 rounded-lg overflow-hidden shadow-xl transform transition-all sm:max-w-lg sm:w-full">

                <div class="flex w-full bg-slate-300 justify-end py-2 px-4">
                    <button @click="$wire.showModal = !$wire.showModal" type="button"
                        class=" self-end max-w-6 justify-center w-full rounded-full border border-gray-300  bg-white text-base leading-6 font-medium text-gray-700 shadow-sm hover:text-gray-500 focus:outline-none focus:border-blue-300 focus:shadow-outline transition ease-in-out duration-150 sm:text-sm sm:leading-5">
                        X
                    </button>
                </div>

                <div class="bg-white lg:p-0 lg:pr-4 sm:p-6 sm:pb-4">
                    <div class="sm:flex sm:items-start overflow-y-auto max-h-100">
                        <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                            <x-helpers.forms.notes :$accountList :selectedAccountId="$accountId" :$storeList :selectedStoreId="$storeId" />
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>



    {{-- <div x-data={open:$wire.showModal}>
        <h1 x-show="$wire.showModal" x-text="open"></h1>
        <div x-show="open"
            class="font-sans antialiased fixed bottom-0 inset-x-0 px-4 pb-4 sm:inset-0 sm:flex sm:items-center sm:justify-center">
            <div x-show="open" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0"
                x-transition:enter-end="opacity-100" x-transition:leave="ease-in duration-200"
                x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
                class="fixed inset-0 transition-opacity">
                <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
            </div>

            <div x-show="open" x-transition:enter="ease-out duration-300"
                x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                x-transition:leave="ease-in duration-200"
                x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                class="bg-white rounded-lg overflow-hidden shadow-xl transform transition-all sm:max-w-lg sm:w-full">
                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <div class="sm:flex sm:items-start">
                        <div
                            class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-red-100 sm:mx-0 sm:h-10 sm:w-10">
                            <svg class="h-6 w-6 text-red-600" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                            </svg>
                        </div>
                        <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                            <h3 class="text-lg leading-6 font-medium text-gray-900">
                                Deactivate account
                            </h3>
                            <div class="mt-2">
                                <p class="text-sm leading-5 text-gray-500">
                                    Are you sure you want to deactivate your account? All of your data will be
                                    permanantly
                                    removed. This action cannot be undone.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                    <span class="flex w-full rounded-md shadow-sm sm:ml-3 sm:w-auto">
                        <button @click=" open = $wire.showModal=!$wire.showModal; " type="button"
                            class="inline-flex justify-center w-full rounded-md border border-transparent px-4 py-2 bg-red-600 text-base leading-6 font-medium text-white shadow-sm hover:bg-red-500 focus:outline-none focus:border-red-700 focus:shadow-outline-red transition ease-in-out duration-150 sm:text-sm sm:leading-5">
                            Deactivate
                        </button>
                    </span>
                    <span class="mt-3 flex w-full rounded-md shadow-sm sm:mt-0 sm:w-auto">
                        <button @click=" open = $wire.showModal=!$wire.showModal;" type="button"
                            class="inline-flex justify-center w-full rounded-md border border-gray-300 px-4 py-2 bg-white text-base leading-6 font-medium text-gray-700 shadow-sm hover:text-gray-500 focus:outline-none focus:border-blue-300 focus:shadow-outline transition ease-in-out duration-150 sm:text-sm sm:leading-5">
                            Cancel
                        </button>
                    </span>
                </div>
            </div>
        </div>
    </div> --}}

</x-helpers.parts.modal-content-panel>


@script
    <script>
        $wire.on('toggle-modal', () => {

            if ($('#details').length > 0) {
                $('#details').summernote({
                    disableDragAndDrop: false,
                    placeholder: 'Note Details',
                    toolbar: [
                        // ['style', ['style']],
                        // ['font', ['bold', 'underline', 'clear', 'color']],
                        // ['color', ['color']],
                        // ['para', ['ul', 'ol', 'paragraph']],
                        // ['table', ['table']],

                        ['style', ['bold', 'italic', 'underline', 'clear']],
                        // ['font', ['strikethrough', 'superscript', 'subscript']],
                        ['fontsize', ['fontsize']],
                        ['color', ['color']],
                        ['para', ['ul', 'ol', 'paragraph']],
                        ['height', ['height']]

                    ],
                    callbacks: {
                        onChange: function(contents, $editable) {
                            @this.set('details', contents);
                        }
                    }
                });

                $('#details').summernote('code', $wire.details);

            }

            // });
        });


        $(document).ready(function() {

            // let details = $('#details').summernote({
            //     toolbar: [
            //         ['style', ['style']],
            //         ['font', ['bold', 'underline', 'clear']],
            //         ['color', ['color']],
            //         ['para', ['ul', 'ol', 'paragraph']],
            //         ['table', ['table']],
            //         ['insert', ['link', 'picture', 'video']],
            //         ['view', ['fullscreen', 'codeview', 'help']]
            //     ],
            //     callbacks: {
            //         onChange: function(contents, $editable) {
            //             console.log(contents);
            //             @this.set('details', contents);
            //         }
            //     }
            // });

        });
    </script>
@endscript
