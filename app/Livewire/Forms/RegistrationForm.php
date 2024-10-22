<?php

namespace App\Livewire\Forms;

use Livewire\Attributes\Session;
use Livewire\Attributes\Validate;
use Livewire\Form;

class RegistrationForm extends Form
{
    #[Session]
    public $firstName;
    #[Session]
    public $middleName;
    #[Session]
    public $lastName;

    #[Session]
    public $gender;
    #[Session]
    public $dateOfBirth;
    #[Session]
    public $contactNumber;
    #[Session]
    public $bricNumber;

    public $validId;
    public $email;
    public $password;
    public $password_confirmation;
    public $accessCode;
}
