@props(['status' => 'active'])
<span
    class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $status == 'active' ? 'bg-green-300 text-green-800' : 'bg-slate-300 text-slate-500' }} ">
    {{ $status }}
</span>
