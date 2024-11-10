<?php

namespace App\Livewire\Forms;

use Livewire\Attributes\Validate;
use Livewire\Form;

class CertificateOfResidencyWalkInForm extends Form
{
    #[Validate('required')]
    public $fullName;

    #[Validate('required')]
    public $civilStatus;

    #[Validate('required')]
    public $gender;

    #[Validate('required')]
    public $address;

    #[Validate('required')]
    public $dateOfBirth;
}
