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
                $message = "Unable to {$operation} {$this->module}  !";
                $bg_color = 'bg-rose-500 ';
                $icon = 'error';
                break;
            case 'error':
                $type = $status;
                $message = "Error while Processing to {$operation} {$this->module}  !";
                $bg_color = 'bg-yellow-500 ';
                $icon = 'warning';
                break;
            default:
                $type = 'success';
                $operationDone = $this->pastTense($operation);
                $message = "{$this->module} {$operationDone} Successfully";
                $bg_color = 'bg-green-500 ';
                $icon = 'check';
                break;
        }

        $bg_color = $bg_color . '/' . $opcity;

    @endphp
    <div
        class="drop-shadow-md fixed mt-4 top-0  right-0 min-h-6  px-2 py-2 rounded-l text-sm flex justify-center items-center animate-toasts {{ $bg_color }}">
        <span class="material-symbols-outlined">{{ $icon }}</span>
        {{ ucwords($message) }}
    </div>
@endif
