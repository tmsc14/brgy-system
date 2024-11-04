<?php

namespace App\Livewire\Forms;

use Livewire\Attributes\Validate;
use Livewire\Form;

class ResidentFieldsForm extends Form
{
    public $is_head_of_household;
    public $relationship_to_head;
    public $ethnicity;
    public $religion;
    public $civil_status;
    public $is_temporary_resident;
    public $is_pwd;
    public $is_voter;
    public $is_employed;
    public $is_birth_registered;
    public $is_literate;
}
