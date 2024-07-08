<x-helpers.parts.content-panel>

    <x-slot name="heading">Payment Method</x-slot>

    <x-helpers.parts.data-table.control />
    <x-helpers.parts.data-table.table :tableItems="$paymentMethods" :$limitFilter :$tableFields />

    <x-slot name="modal">
        <x-helpers.modal :id>
            <x-helpers.forms.payment-method :statusList="$statusList" :selectedStatus="$status" />
        </x-helpers.modal>
    </x-slot>

</x-helpers.parts.content-panel>
