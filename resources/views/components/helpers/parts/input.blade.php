@props(['name' => '', 'liveChange' => false, 'defer' => false, 'upper' => false])


@php

    $defaults = [
        'type' => 'text',
        'id' => strtolower(preg_replace('/(?<!^)[A-Z]/', '_$0', $name)),
        'name' => strtolower(preg_replace('/(?<!^)[A-Z]/', '_$0', $name)),
        'class' =>
            'block w-full rounded-md border-0 py-1.5 pr-20 text-gray-900 ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-purple-300 sm:text-sm sm:leading-6 ' .
            ($upper ? ' uppercase' : ''),
    ];

    $fieldLabel = ucwords(str_replace('_', ' ', strtolower(preg_replace('/(?<!^)[A-Z]/', '_$0', $name))));

    $eventType = 'wire:model=' . $name;
    if ($liveChange) {
        $eventType = 'wire:model.change=' . $name;
    } elseif ($defer) {
        $eventType = 'wire:model.defer=' . $name;
    }
@endphp

<div class="mb-2">
    <label for="{{ $name }}" class="block text-sm font-medium leading-6 text-gray-600">{{ $fieldLabel }}</label>
    <div class="relative mt-1 rounded-md shadow-sm">
        <input {{ $eventType }} autocomplete="off" {{ $attributes($defaults) }}>
    </div>
    <div class="text-xs text-rose-500 mt-1">
        @error($name)
            {{ $message }}
        @enderror
    </div>
</div>
