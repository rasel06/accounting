<x-helpers.parts.content-panel>
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


    <x-slot name="modal">
        <x-helpers.modal :id>
            <x-helpers.forms.notes :$accountList :selectedAccountId="$accountId" :$storeList :selectedStoreId="$storeId" />
        </x-helpers.modal>
    </x-slot>



</x-helpers.parts.content-panel>


@script
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            @this.on('showModalUpdated', function() {
                // Call your JavaScript function here
                myJsFunction();
            });
        });


        // document.addEventListener("DOMContentLoaded", function() {
        //     @this.on('update', function(value) {
        //         // Call your JavaScript function here
        //         myJsFunction(value);
        //     });
        // });
        $(document).ready(function() {

            $('#details').summernote({
                placeholder: 'Note Details',
                tabsize: 2,
                height: 120,
                toolbar: [
                    ['style', ['style']],
                    ['font', ['bold', 'underline', 'clear']],
                    ['color', ['color']],
                    ['para', ['ul', 'ol', 'paragraph']],
                    ['table', ['table']],
                    // ['insert', ['link', 'picture', 'video']],
                    // ['view', ['fullscreen', 'codeview', 'help']]
                ]
            });


        });
    </script>
@endscript
