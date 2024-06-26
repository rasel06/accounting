<div>
    <div class="max-w-full mx-auto px-4  bg-slate-300 rounded-lg transition-all duration-500 ease-in-out">
        <div class="flex flex-col items-stretch">
            <h1 class="text-xl font-bold text-cyan-500 py-2">Dashboard<span>::</span> </h1>
            <hr class="border-slate-500/40 ">

            <div class="py-4 flex gap-4 flex-col">
                <div class="flex flex-row gap-4 justify-between items-stretch">
                    <x-helpers.parts.dashboard.card class="w-3/6 p-4 bg-white/90 min-h-48 drop-shadow rounded-lg">

                        <div id="debit"></div>
                    </x-helpers.parts.dashboard.card>
                    <x-helpers.parts.dashboard.card class="w-3/6 p-4 bg-white/90 min-h-48 drop-shadow rounded-lg">

                        <div id="credit"></div>
                    </x-helpers.parts.dashboard.card>

                </div>

                <x-helpers.parts.dashboard.card class="w-full p-4 bg-white/90 min-h-48 drop-shadow rounded-lg" />
            </div>

        </div>
    </div>

</div>
