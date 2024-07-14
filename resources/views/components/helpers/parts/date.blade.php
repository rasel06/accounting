@props(['name' => '', 'range' => false])

@php

    $name = trim($name);
    $fromDate = $name == '' ? 'fromDate' : $name . 'FromDate';
    $toDate = $name == '' ? 'toDate' : $name . 'ToDate';

    $fromId = $this->camelToSnake($fromDate);
    $toId = $this->camelToSnake($toDate);

    $defaults = [
        // 'autocomplete' => 'off',
        // 'value' => date('Y-m-d'),
        'type' => 'date',
        // 'id' => strtolower(preg_replace('/(?<!^)[A-Z]/', '_$0', $name)),
        // 'name' => strtolower(preg_replace('/(?<!^)[A-Z]/', '_$0', $name)),
        'class' =>
            'block w-full rounded-md border-0 py-1.5 text-gray-900 ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-purple-300 sm:text-sm sm:leading-6 ',
    ];
    $fieldLabel = ucwords(str_replace('_', ' ', strtolower(preg_replace('/(?<!^)[A-Z]/', '_$0', $name))));

    // $eventType = 'wire:model=' . $name;

@endphp

<div class="mb-2">
    {{-- <label for="{{ $name }}" class="block text-sm font-medium leading-6 text-gray-600">{{ $fieldLabel }}</label> --}}
    <div class="relative mt-1 rounded-md shadow-sm flex gap-2" x-data="{
        {{ $fromDate }}: new Date().toISOString().split('T')[0],
        {{ $toDate }}: new Date().toISOString().split('T')[0],
        updateToDateMin() {
            if (this.{{ $toDate }} < this.{{ $fromDate }}) this.{{ $toDate }} = this.{{ $fromDate }}
        },

    }">
        <div>
            <label for="{{ $fromId }}">From Date:</label>
            <input {{ $attributes($defaults) }} id="{{ $fromId }}" x-model="{{ $fromDate }}"
                wire:model="{{ $fromDate }}" max="{{ date('Y-m-d') }}" @change="updateToDateMin ;">
        </div>
        <div>
            <label for="{{ $toId }}">To Date:</label>
            <input {{ $attributes($defaults) }} id="{{ $toId }}" x-model="{{ $toDate }}"
                wire:model="{{ $toDate }}" min="{{ $fromDate }}" max="{{ date('Y-m-d') }}">
        </div>

    </div>
    <div class="text-xs text-rose-500 mt-1">
        @error($name)
            {{ $message }}
        @enderror
    </div>
</div>
