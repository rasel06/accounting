@php
    // $defaults = [
    //     'class' => 'hover:bg-gray-50 focus:ring-2 focus:ring-indigo-200 border px-2 py-1',
    // ];
@endphp

<button
    {{ $attributes->merge(['class' => 'hover:bg-gray-50 hover:text-cyan-600 focus:ring-2 focus:ring-indigo-200 border px-2 py-0.5 text-sm flex justify-center items-center']) }}
    type="button">
    {{ $slot }}
</button>
