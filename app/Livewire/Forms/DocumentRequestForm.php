<?php

namespace App\Livewire\Forms;

use Livewire\Attributes\Validate;
use Livewire\Form;

class DocumentRequestForm extends Form
{
    #[Validate('required')]
    public $entity_id;

    #[Validate('required')]
    public $entity_type;
}
