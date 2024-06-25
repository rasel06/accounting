@props(['icon' => '', 'label' => '', 'link' => ''])


@php
    $status = ' hidden ';
    if ($link != '') {
        if ($link != '') {
            $status = request()->is($link . '/*') ? '' : 'hidden';
        }
    }
@endphp

<li>
    <button type="button"
        class="main-menu flex items-center w-full p-2 text-base font-normal transition duration-75  group hover:bg-slate-300 dark:text-white dark:hover:bg-gray-700"
        aria-controls="dropdown-{{ strtolower($label) }}" data-collapse-toggle="dropdown-{{ strtolower($label) }}">
        <span class="material-symbols-outlined">
            {{ $icon }}
        </span>
        <span class="flex-1 ml-3 text-left whitespace-nowrap" sidebar-toggle-item>{{ $label }}</span>
        <span class="material-symbols-outlined">
            keyboard_arrow_down
        </span>
    </button>
    <ul id="dropdown-{{ strtolower($label) }}" class="py-2 space-y-1 {{ $status }} submenu">
        {{ $slot }}
    </ul>
</li>
