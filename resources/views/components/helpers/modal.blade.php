@props(['header' => '', 'footer' => '', 'color' => 'bg-slate-200', 'userId' => ''])

@php
    $defaults = [
        'color' => $color,
    ];
@endphp



<div class=" fixed min-h-full  min-w-full bg-slate-600/50 z-20 left-0 top-0 flex duration-1000 transition ease-in-out">
    <div class="w-2/5 h-2/5 mx-auto my-auto flex flex-col justify-between drop-shadow-lg">
        <div class="{{ $color }} px-2 py-1 min-h-6 min-w-full rounded-t-md">
            <div class="flex justify-between items-center">
                <h1 class="text-slate-500">{{ $header }}</h1>
                <button class="text-slate-600" wire:click="modalClose">
                    <span class="material-symbols-outlined ">
                        close
                    </span>
                </button>
            </div>
        </div>
        <div class="min-h-6 bg-slate-50 p-4">
            {{ $slot }}
        </div>
        <div class="{{ $color }}  px-4 py-1 min-h-6 min-w-full rounded-b-md">{{ $footer }}</div>
    </div>
</div>
