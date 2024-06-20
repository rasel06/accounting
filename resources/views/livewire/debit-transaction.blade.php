<div class="">
    <div class="w-full h-fit ">
        <div class="max-w-7xl mx-auto sm:px-4 lg:px-3 bg-slate-300 rounded-lg ">
            <div class="flex flex-col items-stretch">
                <h1 class="text-xl font-bold text-cyan-500 py-2">Debit Transaction <span>::</span> </h1>
                <hr class="border-slate-500/40 ">

                <x-helpers.parts.data-table.control :showStatus="false" />

                <div class=" py-0  ">
                    <x-helpers.parts.data-table.debit-transaction-table :tableItems="$debitTransactionList" :$limitFilter :$tableFields />
                </div>
            </div>
        </div>

        {{-- Modal for create new item --}}

        @if ($showModal)
            <x-helpers.modal header="{{ $id == null ? 'Create New' : 'Update' }}">
                <x-helpers.forms.debit-transaction :$paymentMethodList :selectedPaymentMethodId="$paymentMethodId" />
            </x-helpers.modal>
        @endif
    </div>
</div>
