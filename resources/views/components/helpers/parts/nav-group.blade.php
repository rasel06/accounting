@props(['icon' => '', 'label' => '', 'link' => ''])


@php
    $active = '';
    $status = '';
    if ($link != '') {
        $active = request()->is($link) ? 'bg-slate-300' : '';

        $parts = explode('/', $link);

        if (sizeof($parts) >= 1) {
            $status = request()->is($parts[0] . '/*') ? '' : 'hidden';
        }
    }
@endphp

<li>
    <button type="button"
        class="flex items-center w-full p-2 text-base font-normal transition duration-75 rounded-lg group hover:bg-slate-100 dark:text-white dark:hover:bg-gray-700"
        aria-controls="dropdown-{{ strtolower($label) }}" data-collapse-toggle="dropdown-{{ strtolower($label) }}">
        <span class="material-symbols-outlined">
            {{ $icon }}
        </span>
        <span class="flex-1 ml-3 text-left whitespace-nowrap" sidebar-toggle-item>{{ $label }}</span>
        <span class="material-symbols-outlined">
            keyboard_arrow_down
        </span>
    </button>
    <ul id="dropdown-{{ strtolower($label) }}" class="hidden py-2 space-y-1 {{ $status }}">
        {{ $slot }}
    </ul>
</li>
