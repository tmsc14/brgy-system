<?php

namespace App\Livewire\Customize;

use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.app')]
class Customize extends Component
{
    public function render()
    {
        return view('livewire.customize.customize');
    }
}
