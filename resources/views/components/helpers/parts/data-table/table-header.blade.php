@props(['tableFields' => []])

@foreach ($tableFields as $key => $value)
    @php
        $sortBy = isset($value['sortable']) ? $key : '';
    @endphp
    <x-helpers.parts.data-table.th :sortBy="$sortBy" class="text-left {{ isset($value[1]) ? $value[1] : '' }}">
        {{ $value[0] }}
    </x-helpers.parts.data-table.th>
@endforeach
