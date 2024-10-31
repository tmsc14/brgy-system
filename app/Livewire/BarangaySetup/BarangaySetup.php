<?php

namespace App\Livewire\BarangaySetup;

use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.welcome')]
class BarangaySetup extends Component
{
    public function render()
    {
        return view('livewire.barangay-setup.barangay-setup');
    }
}
