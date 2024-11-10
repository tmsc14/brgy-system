<?php

namespace App\Livewire\Forms;

use Livewire\Attributes\Validate;
use Livewire\Form;

class BusinessPermitWalkInForm extends Form
{
    #[Validate('required')]
    public $fullName;
}
