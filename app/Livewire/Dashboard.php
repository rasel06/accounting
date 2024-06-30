<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\Attributes\Title;

class Dashboard extends Component
{
    #[Title('Dashboard')]
    public function render()
    {
        // https://chasingcode.dev/blog/laravel-livewire-dynamic-charts-apexcharts/
        return view('livewire.dashboard');
    }

    public function dehydrate()
    {
    }
}
