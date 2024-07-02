@props([])

<div x-data="{ toastShow: true }" x-show="toastShow" x-transition.delay.50ms
    class="fixed top-0 right-0 min-h-6 bg-rose-500/50 px-2 py-2 rounded-l mt-4 text-sm flex justify-center items-center ">
    <span class="material-symbols-outlined">
        warning
    </span>

    <span class="material-symbols-outlined">
        error
    </span>

    <span class="material-symbols-outlined">
        check
    </span>

    okok

    {{ $this->showModal }}
</div>

{{-- <div class="absolute  bg-green-500 text-white p-4 rounded opacity-0 transition-opacity duration-300 delay-1000">
    @if (session('message'))
        {{ session('message') }}
    @endif
</div> --}}
