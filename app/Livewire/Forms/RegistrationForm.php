<?php

namespace App\Livewire\Forms;

use Livewire\Attributes\Validate;
use Livewire\Form;

class RegistrationForm extends Form
{
    public $firstName;
    public $middleName;
    public $lastName;

    public $gender;
    public $dateOfBirth;
    public $contactNumber;
    public $bricNumber;

    public $validId;
    public $email;
    public $password;
    public $password_confirmation;
    public $accessCode;
}
