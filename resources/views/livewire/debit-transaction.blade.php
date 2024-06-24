<div>
    <div class="w-full mx-auto px-4  bg-slate-300 rounded-lg ">
        <div class="flex flex-col items-stretch">
            <h1 class="text-xl font-bold text-cyan-500 py-2">Debit Transaction <span>::</span> </h1>
            <hr class="border-slate-500/40 ">

            <x-helpers.parts.data-table.control :showStatus="false" />

            <x-helpers.parts.data-table.debit-transaction-table :tableItems="$debitTransactionList" :$limitFilter :$tableFields />
        </div>
    </div>


    @if ($showModal)
        <x-helpers.modal :id>
            <x-helpers.forms.debit-transaction :$paymentMethodList :selectedPaymentMethodId="$paymentMethodId" />
        </x-helpers.modal>
    @endif

</div>
