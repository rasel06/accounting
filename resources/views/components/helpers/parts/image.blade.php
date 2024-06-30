@props(['file' => '', 'path' => 'storage', 'size' => 'size-6'])

@if ($file)
    @php
        $filePath = $path . '/' . $file;
    @endphp
    @if (file_exists(public_path($filePath)))
        <img wire:click="showInvoice" class="{{ $size }} inline cursor-pointer" src="{{ asset($filePath) }}">
    @else
        <span class="text-rose-500">N/F</span>
    @endif
@else
    <span class="text-slate-500"> -- </span>
@endif
