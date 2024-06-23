@props(['status' => 'active'])

{{-- py-1 flex items-center justify-center text-xs  font-semibold rounded-full bg-green-300 text-green-800 --}}
<span
    class="max-w-16 py-1 flex items-center justify-center text-xs  font-semibold rounded-full {{ $status == 'active' ? 'bg-green-300 text-green-800' : 'bg-slate-300 text-slate-500' }} ">
    {{ $status }}
</span>
