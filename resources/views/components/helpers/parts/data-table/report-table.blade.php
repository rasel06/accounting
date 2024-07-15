@props([])



{{-- -my-2 py-2 sm:-mx-6 sm:px-6 lg:-mx-8 lg:px-8  --}}
<div class="pb-6">


    <div class="align-middle inline-block w-full shadow overflow-x-auto sm:rounded-lg border-b border-gray-200 ">
        <table class="min-w-full text-slate-900 ">
            <thead>
                <tr
                    class="bg-slate-500 border-b font-extrabold border-gray-200 text-xs leading-4 text-gray-100 uppercase tracking-wider">
                </tr>
            </thead>
            <tbody class="bg-white">
                {{ $slot }}
            </tbody>
        </table>
    </div>


</div>
