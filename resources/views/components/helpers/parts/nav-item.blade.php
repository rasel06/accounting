@props(['icon' => '', 'label' => '', 'link' => '', 'subMenu' => false])


@php
    $active = '';
    if ($link != '') {
        $active = request()->is($link) ? 'bg-slate-300' : '';
    }
@endphp

@if ($subMenu)
    <li>
        <a wire:navigate href="/{{ $link }}"
            class="flex items-center w-full p-2 text-base font-normal text-gray-900 transition duration-75 group hover:bg-slate-300 dark:text-white dark:hover:bg-gray-700 pl-14 {{ $active }}">{{ $label }}</a>
    </li>
@else
    <li>
        <a wire:navigate href="/{{ $link }}"
            class="flex items-center p-2 text-base font-normal dark:text-white hover:bg-slate-300 dark:hover:bg-gray-700 {{ $active }} ">
            @if ($icon != '')
                <span class="material-symbols-outlined">
                    {{ $icon }}
                </span>
            @endif
            <span class="ml-3">{{ $label }}</span>
        </a>
    </li>
@endif