<?php

namespace App\Livewire\Forms;

use Livewire\Attributes\Validate;
use Livewire\Form;

class CertificateOfIndigencyForm extends DocumentRequestForm
{
    #[Validate('nullable')]
    public $guardian_name;

    #[Validate('nullable')]
    public $relationship_to_guardian;
    
    #[Validate('required')]
    public $purpose;

    #[Validate(['files.*' => 'required|file|mimes:jpeg,png,jpg,pdf|max:10240'])]
    public $files;
}
