{{-- https://dev.to/nasrulhazim/livewire-chartjs-3ch5 --}}

@props(['width' => 'w-2/3'])

@php
    $defaultClasses = ' p-4 rounded ' . $width;

    $defaults = [
        'class' => 'ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 ',
    ];

    $data = $attributes($defaults);

    // echo '<pre>';
    // print_r($data);

    // $attributes->merge(['class' => $class]);

    // print_r($data);
    // echo '</pre>';

@endphp

<div {{ $attributes }} x-data="{
    init() {
        console.log('I am called automatically')
    }
}">
    {{ $slot }}
</div>
