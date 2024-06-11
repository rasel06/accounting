@props(['label' => '', 'name' => '', 'placeholder' => ''])


@php
    $defaults = [
        // 'wire:change.live' => $name,
    ];
@endphp

<form {{ $attributes($defaults) }}>
    <div class="flex flex-col justify-between">

        <div> {{ $slot }}</div>
        <div class="flex justify-between ">
            <div>
                <div class=" flex justify-center items-center" wire:loading>
                    <svg class="h-5 w-5 text-green-700 animate-spin" xmlns="http://www.w3.org/2000/svg" fill="none"
                        viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                            stroke-width="4">
                        </circle>
                        <path class="opacity-75" fill="currentColor"
                            d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                        </path>
                    </svg>
                </div>
            </div>
            <div class="flex gap-2">
                <buttonn type="reset" class="text-slate-400" wire:click="clean">
                    <span class="material-symbols-outlined">device_reset</span>
                </buttonn>
                <button type="submit" class="text-cyan-400">
                    <span class="material-symbols-outlined">save</span>
                </button>
            </div>

        </div>
    </div>
</form>
