@props(['icon' => '', 'label' => '', 'link' => ''])


<li x-data="{ isOpen: false }" x-init="currentMenu = window.location.pathname.split('/')[1];
parentMenu = '{{ $link }}';
isOpen = (currentMenu == parentMenu) ? true : false;">
    <button @click="isOpen = !isOpen" type="button"
        class="flex items-center w-full p-2 text-base font-normal hover:text-white group hover:bg-slate-500 dark:text-white dark:hover:bg-gray-700"
        aria-controls="dropdown-{{ strtolower($label) }}" data-collapse-toggle="dropdown-{{ strtolower($label) }}">
        <span class="material-symbols-outlined">
            {{ $icon }}
        </span>
        <span class="flex-1 ml-3 text-left whitespace-nowrap">{{ $label }}</span>
        <span class="material-symbols-outlined menu-icon transition-transform" :class="isOpen ? ' rotate-90 ' : ''">
            keyboard_arrow_down
        </span>
    </button>

    <ul :class="isOpen ? ' opacity-100 ' : ' max-h-0 opacity-0 '" id="dropdown-{{ strtolower($label) }}"
        class="space-y-1 transition-all duration-500 ease-in-out overflow-hidden">
        {{ $slot }}
    </ul>
</li>
