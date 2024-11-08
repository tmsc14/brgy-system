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

    public $requires_documents = false;

    public function getAdditionalFieldNames()
    {
        return array_keys($this->except(['entity_id', 'entity_type', 'requires_documents', 'files']));
    }

    public function getAdditionalFields()
    {
        return $this->except(['entity_id', 'entity_type', 'requires_documents']);
    }
}
