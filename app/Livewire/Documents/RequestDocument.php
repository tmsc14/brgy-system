<?php

namespace App\Livewire\Documents;

use App\Enums\Documents\DocumentType;
use Livewire\Attributes\Locked;
use Livewire\Component;

class RequestDocument extends Component
{
    #[Locked]
    public $userType;

    public function mount($userType)
    {
        $this->userType = $userType;
    }
    
    public function requestDocument($documentType)
    {
        $this->redirectRoute('documents.request-document.' . strtolower($this->userType . '.' . $documentType));
    }

    public function render()
    {
        $documentRequestTypes = DocumentType::cases();
        return view('livewire.documents.request-document', compact('documentRequestTypes'));
    }
}
