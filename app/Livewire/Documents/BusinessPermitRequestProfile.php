<?php

namespace App\Livewire\Documents;

use App\Enums\Documents\DocumentType;
use App\Livewire\Forms\BusinessPermitForm;
use App\Livewire\Forms\BusinessPermitWalkInForm;
use App\Services\DocumentsGeneratorService;
use App\Traits\DocumentRequestProfileTrait;
use Livewire\Attributes\Locked;
use Livewire\Component;

class BusinessPermitRequestProfile extends Component
{
    use DocumentRequestProfileTrait;

    public BusinessPermitForm $form;

    public BusinessPermitWalkInForm $walkInForm;

    #[Locked]
    public $documentType = DocumentType::BUSINESS_PERMIT;

    #[Locked]
    public $requiredFiles = [
        "Barangay Clearance",
        "Certificate of Registration",
        "Contract of Lease",
        "Certificate of Occupancy",
        "Community Tax",
        "Fire Safety Inspection Certificate or Fire Permit",
        "Building Permit and Electrical Inspection"
    ];

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
