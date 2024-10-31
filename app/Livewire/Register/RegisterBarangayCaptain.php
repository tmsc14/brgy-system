<?php

namespace App\Livewire\Register;

use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.welcome')]
class RegisterBarangayCaptain extends Component
{
    public $title = "Barangay Captain";

    public function render()
    {
        return view('livewire.register.register-barangay-captain');
    }
}
