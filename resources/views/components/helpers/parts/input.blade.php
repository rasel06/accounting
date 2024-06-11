@props(['label' => '', 'name' => '', 'placeholder' => ''])


@php
    $defaults = [
        // 'wire:change.live' => $name,
        'type' => 'text',
        'id' => $name,
        'name' => $name,
        'class' =>
            'block w-full rounded-md border-0 py-1.5 pr-20 text-gray-900 ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-purple-300 sm:text-sm sm:leading-6',
    ];
@endphp

<div class="mb-2">
    <label for="{{ $name }}" class="block text-sm font-medium leading-6 text-gray-600">{{ $label }}</label>
    <div class="relative mt-1 rounded-md shadow-sm">
        {{-- <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
            <span class="text-gray-500 sm:text-sm">$</span>
        </div> --}}
        <input {{ $attributes($defaults) }}>
        {{-- <div class="absolute inset-y-0 right-0 flex items-center">
            <label for="currency" class="sr-only">Currency</label>
            <select id="currency" name="currency"
                class="h-full rounded-md border-0 bg-transparent py-0 pl-2 pr-7 text-gray-500 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm">
                <option>USD</option>
                <option>CAD</option>
                <option>EUR</option>
            </select>
        </div> --}}
    </div>
    <div class="text-sm text-rose-500">
        @error($name)
            {{ $message }}
        @enderror
    </div>
</div>
