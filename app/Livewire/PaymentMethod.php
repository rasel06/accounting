<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Layout;
use Livewire\WithoutUrlPagination;
use App\Models\PaymentMethod as PayMethods;


class PaymentMethod extends Component
{

    use WithPagination, WithoutUrlPagination;

    public $title = "Payment Method";
    public $status = "";
    public $paymentName = "";
    // public $paymentMethods = [];


    public function placeholder()
    {
        return <<<'HTML'
        <div>
            <!-- Loading spinner... -->
            <div class="size-10 bg-red-500">ok</div>
        </div>
        HTML;
    }

    public function mount()
    {
        // $this->paymentMethods = PayMethods::paginate(10);
    }

    protected function paymentMethods()
    {
        return $this->status === '' ? PayMethods::paginate(10) :  PayMethods::where('status', $this->status)->paginate(10);
    }


    public function render()
    {

        // echo (" OK " . $this->status . " == " . $this->paymentName);
        // if ($this->status == 'active') {
        //     $paymentMethods = PayMethods::where('status', 'active')->paginate(10);
        // } elseif ($this->status == 'inactive') {
        //     $paymentMethods = PayMethods::where('status', 'inactive')->paginate(10);
        // } else {
        //     $paymentMethods = PayMethods::paginate(10);
        // }

        return view('livewire.payment-method', [
            "paymentMethods" => $this->paymentMethods()
        ]);
    }
}
