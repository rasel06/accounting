@props(['type' => 'success'])

@php

    $opcity = 50;
    switch ($type) {
        case 'danger':
            $bg_color = 'bg-rose-500 ';
            $icon = 'error';
            break;
        case 'warning':
            $bg_color = 'bg-yellow-500 ';
            $icon = 'warning';
            break;
        default:
            $bg_color = 'bg-green-500 ';
            $icon = 'check';
            break;
    }

    $bg_color = $bg_color . '/' . $opcity;

@endphp

@if (session('notify'))
    <div
        class="drop-shadow-md fixed mt-4 top-0  right-0 min-h-6  px-2 py-2 rounded-l text-sm flex justify-center items-center animate-toasts {{ $bg_color }}">
        <span class="material-symbols-outlined">
            {{ $icon }}
        </span>
        {{ $this->module }}

        {{ print_r(session('message')) }}
    </div>
@endif
