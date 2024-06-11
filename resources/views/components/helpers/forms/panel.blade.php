@props(['label' => '', 'name' => '', 'placeholder' => ''])


@php
    $defaults = [
        // 'wire:change.live' => $name,
    ];
@endphp

<form {{ $attributes($defaults) }}>
    <div class="flex flex-col justify-between">

        <div> {{ $slot }}</div>
        <div class="flex justify-end ">
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
