<?php

namespace App\Livewire\Forms;

use Livewire\Attributes\Validate;
use Livewire\Form;

class CertificateOfIndigencyWalkInForm extends Form
{
    #[Validate('required')]
    public $fullName;

    #[Validate('required')]
    public $dateOfBirth;

    #[Validate('required')]
    public $gender;
}
