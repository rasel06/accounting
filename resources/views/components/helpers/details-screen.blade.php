<div>

    @php

    @endphp
    <ul>

        @foreach ($this->itemDetails[0] as $key => $value)
            <li>{{ $key }} :: {{ gettype($value) }}</li>
        @endforeach

    </ul>

    {{-- {{ print_r($this->itemDetails) }} --}}
</div>
