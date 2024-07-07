<x-helpers.parts.content-panel>
    <x-slot name="heading">
        Business Location
    </x-slot>

    <x-helpers.parts.data-table.control />
    <x-helpers.parts.data-table.table :tableItems="$businessLocation" :$limitFilter :$tableFields />


    <x-slot name="modal">
        <x-helpers.modal :id>
            <x-helpers.forms.business-location :statusList="$statusList" :selectedStatus="$status" />
        </x-helpers.modal>
    </x-slot>

</x-helpers.parts.content-panel>
