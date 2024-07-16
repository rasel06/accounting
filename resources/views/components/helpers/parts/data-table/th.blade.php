@props(['size' => '', 'sortBy' => ''])

<th {{ $attributes->merge(['class' => 'px-2 py-2 font-bold ' . $size]) }}>
    @if ($sortBy !== '')
        <div class="flex justify-start content-center items-center">
            <div> {{ $slot }}</div>
            <div class="flex flex-col pl-2" x-data="{ ascIconColor: 'text-slate-400', descIconColor: 'text-slate-600' }">
                <div @click="ascIconColor = 'text-slate-400'; descIconColor = 'text-slate-600';"
                    wire:click="sortBy('<?= $sortBy ?>','asc')"
                    class="w-4 h-3 flex justify-center items-center overflow-hidden cursor-pointer">
                    <span class="material-symbols-outlined" :class="ascIconColor">stat_1</span>
                </div>
                <div @click="ascIconColor = 'text-slate-600'; descIconColor = 'text-slate-400';"
                    wire:click="sortBy('<?= $sortBy ?>','desc')"
                    class="w-4 h-2 flex justify-center items-center overflow-hidden cursor-pointer">
                    <span class="material-symbols-outlined rotate-180" :class="descIconColor">stat_1</span>
                </div>
            </div>
        </div>
    @else
        {{ $slot }}
    @endif

</th>
