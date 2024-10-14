<?php

namespace App\Livewire\Register;

use Livewire\Component;

class Register extends Component
{
    public function render()
    {
        return view('livewire.register.register');
    }

    public function register()
    {
        error_log("RAAAA");
    }
}
