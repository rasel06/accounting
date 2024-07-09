@props(['name' => '', 'range' => false])

@php

    $defaults = [
        'autocomplete' => 'off',
        'value' => date('Y-m-d'),
        'type' => 'text',
        'id' => strtolower(preg_replace('/(?<!^)[A-Z]/', '_$0', $name)),
        'name' => strtolower(preg_replace('/(?<!^)[A-Z]/', '_$0', $name)),
        'class' =>
            'block w-full rounded-md border-0 py-1.5 text-gray-900 ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-purple-300 sm:text-sm sm:leading-6 ',
    ];
    $fieldLabel = ucwords(str_replace('_', ' ', strtolower(preg_replace('/(?<!^)[A-Z]/', '_$0', $name))));
    $eventType = 'wire:model=' . $name;
@endphp

<div class="mb-2">
    <label for="{{ $name }}" class="block text-sm font-medium leading-6 text-gray-600">{{ $fieldLabel }}</label>
    <div class="relative mt-1 rounded-md shadow-sm" x-data="{
        fromDate: new Date().toISOString().split('T')[0],
        toDate: new Date().toISOString().split('T')[0],
        updateToDateMin() {
            if (this.toDate < this.fromDate) this.toDate = this.fromDate
        }
    }">
        {{-- <input {{ $eventType }} autocomplete="off" {{ $attributes($defaults) }}> --}}

        <div>
            <label for="fromdate">From Date:</label>
            <input {{ $attributes($defaults) }} type="date" id="fromdate" x-model="fromDate" @change="updateToDateMin">
        </div>
        <div>
            <label for="todate">To Date:</label>
            <input {{ $attributes($defaults) }} type="date" id="todate" x-model="toDate" :min="fromDate">
        </div>
        <div>
            <p>Selected From Date: <span x-text="fromDate"></span></p>
            <p>Selected To Date: <span x-text="toDate"></span></p>
        </div>


    </div>
    <div class="text-xs text-rose-500 mt-1">
        @error($name)
            {{ $message }}
        @enderror
    </div>
</div>
