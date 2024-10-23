<?php

namespace App\Livewire\Forms;

use Livewire\Attributes\Session;
use Livewire\Attributes\Validate;
use Livewire\Form;

class StaffRegistrationFieldsForm extends Form
{
    #[Session]
    public $selectedBarangayId;

    #[Session]
    public $staffRole;

    #[Session]
    public $officialPosition;
}
