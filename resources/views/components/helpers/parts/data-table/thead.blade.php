@props(['tableFields'])

<thead>
    <tr class="bg-slate-500 font-extrabold border-gray-200 text-gray-100 uppercase text-xs ">

        <x-helpers.parts.data-table.th class="text-left ">
            Serial
        </x-helpers.parts.data-table.th>

        <x-helpers.parts.data-table.table-header :$tableFields />

        <x-helpers.parts.data-table.th class="text-right print:hidden">
            Action
        </x-helpers.parts.data-table.th>
    </tr>
</thead>
