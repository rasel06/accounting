@props(['name' => '', 'range' => false])

@php

    $name = trim($name);
    $fromDate = $name == '' ? 'fromDate' : $name . 'FromDate';
    $toDate = $name == '' ? 'toDate' : $name . 'ToDate';

    $fromId = $this->camelToSnake($fromDate);
    $toId = $this->camelToSnake($toDate);

    $defaults = [
        'type' => 'date',
        'class' =>
            'block w-full rounded-md border-0 py-1 text-gray-900 ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-purple-300 sm:text-sm sm:leading-6 ',
    ];
    $fieldLabel = ucwords(str_replace('_', ' ', strtolower(preg_replace('/(?<!^)[A-Z]/', '_$0', $name))));

    // $eventType = 'wire:model=' . $name;

@endphp

<div class="ml-2">


    <div wire:ignore class="flex gap-2 text-slate-500" x-data="{
        fromDate: '',
        toDate: '',
        today: new Date().toISOString().split('T')[0],

        updateToDateMin() {
            if (this.toDate < this.fromDate) {
                this.toDate = this.fromDate;
            }
        }
    }">
        <div class="flex items-center gap-1">
            <label for="fromDate">From:</label>
            <input id="{{ $fromId }}" wire:model.live="{{ $fromDate }}" {{ $attributes($defaults) }}
                x-model="fromDate" :max="today" @change="updateToDateMin">
        </div>
        <div class="flex items-center gap-1">
            <label for="toDate">To:</label>
            <input id="{{ $toId }}" wire:model.live="{{ $toDate }}" {{ $attributes($defaults) }}
                x-model="toDate" :max="today" :min="fromDate">
        </div>
    </div>

    <div class="text-xs text-rose-500 mt-1">
        @error($name)
            {{ $message }}
        @enderror
    </div>
</div>
