<div>
    <div class="w-full mx-auto px-4  bg-slate-300 rounded-lg ">
        <div class="flex flex-col items-stretch">
            <h1 class="text-xl font-bold text-cyan-500 py-2">
                {{ $heading }}
                <span>::</span>
            </h1>
            <hr class="border-slate-500/40 ">
            {{ $slot }}
            <x-helpers.parts.toast />
        </div>
    </div>

    {{-- @if ($this->showModal)
        {{ $modal }}
    @endif --}}
</div>
