@props(['label' => '', 'name' => '', 'placeholder' => ''])


@php
    $defaults = [
        'id' => $name,
        'name' => $name,
        'class' =>
            'block w-full rounded-md border-0 py-1.5 pr-20 text-gray-900 ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-purple-300 sm:text-sm sm:leading-6',
    ];
@endphp

<div class="mb-2">
    <label for="{{ $name }}" class="block text-sm font-medium leading-6 text-gray-600">{{ $label }}</label>
    <div class="relative mt-1 rounded-md shadow-sm">
        <select {{ $attributes($defaults) }}>
            {{ $slot }}
        </select>
    </div>
    <div class="text-sm text-rose-500 mt-1">
        @error($name)
            {{ $message }}
        @enderror
    </div>
</div>
