<?php

namespace App\Livewire\Forms;

use Livewire\Attributes\Validate;
use Livewire\Form;

class BusinessPermitForm extends DocumentRequestForm
{
    #[Validate('required')]
    public $name_of_owner;

    #[Validate('required')]
    public $business_name;
    
    #[Validate('required')]
    public $business_address;

    #[Validate('required')]
    public $source_of_income;

    #[Validate(['files.*' => 'required|file|mimes:jpeg,png,jpg,pdf|max:10240'])]
    public $files;
}
