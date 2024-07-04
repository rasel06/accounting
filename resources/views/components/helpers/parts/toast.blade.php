@if (session('notify'))
    @php

        $noticeData = session('notify');
        $keys = array_keys($noticeData);

        $status = $noticeData[$keys[0]]; // success|failed|error
        $operation = $noticeData[$keys[1]]; // create|update|delete

        $opcity = 50;
        switch ($status) {
            case 'failed':
                $type = $status;
                $message = "Unable to {$operation} {$this->module} ";
                $color = 'rose-500 ';
                $icon = 'error';
                break;
            case 'error':
                $type = $status;
                $message = "Error while Processing to {$operation} {$this->module} ";
                $color = 'yellow-500 ';
                $icon = 'warning';
                break;
            default:
                $type = 'success';
                $operationDone = $this->pastTense($operation);
                $message = "{$this->module} {$operationDone} Successfully ";
                $color = 'green-500 ';
                $icon = 'check';
                break;
        }

        $bg_color = 'bg-' . $color . '/' . $opcity;

    @endphp

    <div @animationend="$el.remove()"
        class="flex gap-2 animate-toasts drop-shadow-md overflow-hidden fixed mt-4 top-0  right-0 min-h-6  px-2 py-2 rounded-l text-sm justify-center items-center  {{ $bg_color }}">
        <div class="bg-white/80 size-8 rounded-full flex items-center justify-center font-bold">
            <span class="material-symbols-outlined text-{{ $color }}">{{ $icon }}</span>
        </div>
        <div class="flex  flex-col ml-2 text-left">
            @if ($this->selectedId != '')
                <h1 class="font-bold text-white">ID :: {{ $this->selectedId }}</h1>
                @php
                    $this->selectedId = '';
                @endphp
            @endif
            <h2>{{ ucwords($message) }} </h2>
        </div>
    </div>
@endif
