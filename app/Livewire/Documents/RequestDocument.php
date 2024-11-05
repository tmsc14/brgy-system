<?php

namespace App\Livewire\Documents;

use App\Enums\Documents\DocumentType;
use Livewire\Component;

class RequestDocument extends Component
{
    public function requestDocument($documentType)
    {
        error_log($documentType);
        $this->redirectRoute('documents.preview.' . strtolower($documentType));
    }

    public function render()
    {
        $documentRequestTypes = DocumentType::cases();
        return view('livewire.documents.request-document', compact('documentRequestTypes'));
    }
}
