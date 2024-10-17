<?php

namespace App\Livewire\Register;

use App\Models\Barangay;
use Livewire\Component;

class SelectBarangayStep extends StepCom
{
    public $barangays;

    public function mount()
    {
        $this->barangays = Barangay::select('id', 'city_code', 'barangay_code')->get();
    }

    public function render()
    {
        return view('livewire.register.select-barangay-step');
    }
}
