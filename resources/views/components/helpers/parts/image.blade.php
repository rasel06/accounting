@props(['file' => '', 'path' => 'storage'])

@if ($file)
    @php
        $filePath = $path . '/' . $file;
    @endphp
    @if (file_exists(public_path($filePath)))
        <img wire:click="showInvoice" class="size-6 inline cursor-pointer" src="{{ asset($filePath) }}">
    @else
        <span class="text-rose-500">N/F</span>
    @endif
@else
    <span class="text-slate-500"> -- </span>
@endif
