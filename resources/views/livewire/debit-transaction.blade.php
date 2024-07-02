<div>
    <div class="w-full mx-auto px-4  bg-slate-300 rounded-lg ">
        <div class="flex flex-col items-stretch">
            <h1 class="text-xl font-bold text-cyan-500 py-2">Debit Transaction <span>::</span> </h1>
            <hr class="border-slate-500/40 ">

            <x-helpers.parts.data-table.control :showStatus="false" />
            <x-helpers.parts.data-table.debit-transaction-table :tableItems="$debitTransactionList" :$limitFilter :$tableFields />


            <x-helpers.parts.toast type="warning" />

            {{-- F:\laravel-projects\blueprint-test\resources\views\components\helpers\parts\toast.blade.php --}}

            {{-- @if (session('message'))
                <div class="alert alert-success">
                    {{ session('message') }}
                </div>
            @endif --}}
        </div>
    </div>


    @if ($showModal)
        <x-helpers.modal :id>
            <x-helpers.forms.debit-transaction :$paymentMethodList :selectedPaymentMethodId="$paymentMethodId" />
        </x-helpers.modal>
    @endif


    @push('scripts')
        <script>
            Livewire.on('myEventName', (data) => {
                console.log('Event received!', data);
                // Call your JavaScript method here
                this.someJsMethod(data);
                this.someData = data.message; // Update component data (optional)
            });

            function someJsMethod(data) {
                // Your JavaScript logic here
                alert(`Data from Livewire: ${data.message}`);
            }
        </script>
    @endpush




</div>
