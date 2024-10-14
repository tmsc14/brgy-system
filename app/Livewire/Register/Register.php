<?php

namespace App\Livewire\Register;

use Livewire\Component;

class Register extends Component
{
    public $stepNumber;

    public function render()
    {
        return view('livewire.register.register');
    }

    public function goToNextStep()
    {

    }

    public function goToPreviousStep()
    {
        
    }
}
