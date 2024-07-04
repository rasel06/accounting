@props(['size' => ''])

<th {{ $attributes->merge(['class' => 'px-2 py-2 font-bold ' . $size]) }}>
    {{ $slot }}
</th>
