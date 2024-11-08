<?php

namespace App\Livewire\Documents;

use App\Enums\Documents\DocumentType;
use App\Livewire\Forms\CertificateOfResidencyRequestForm;
use App\Services\DocumentsGeneratorService;
use App\Traits\DocumentRequestProfileTrait;
use Livewire\Attributes\Locked;
use Livewire\Component;

class CertificateOfResidencyRequestProfile extends Component
{
    use DocumentRequestProfileTrait;

    public CertificateOfResidencyRequestForm $form;

    #[Locked]
    public $documentType = DocumentType::CERTIFICATE_OF_RESIDENCY;

    #[Locked]
    public $requiredFiles = [];
    
    private DocumentsGeneratorService $documentsGeneratorService;

    public function boot(DocumentsGeneratorService $documentsGeneratorService)
    {
        $this->documentsGeneratorService = $documentsGeneratorService;
    }

    public function mount()
    {
        $this->initializeDocumentRequestProfile();
    }
}
