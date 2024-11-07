<?php

namespace App\Livewire\Documents;

use App\Enums\Documents\DocumentType;
use App\Models\DocumentRequest;
use App\Services\DocumentsGeneratorService;
use Barryvdh\DomPDF\Facade\Pdf;
use Livewire\Attributes\Locked;
use Livewire\Component;

class RequestPrintPreview extends Component
{
    private DocumentsGeneratorService $documentsGeneratorService;

    public DocumentRequest $documentRequest;

    public DocumentType $documentType;

    public $documentData;

    public function boot(DocumentsGeneratorService $documentsGeneratorService)
    {
        $this->documentsGeneratorService = $documentsGeneratorService;
    }

    public function mount($id)
    {
        $this->documentRequest = DocumentRequest::find($id);
        $this->documentType = DocumentType::from($this->documentRequest->document_type);
        $this->documentData = $this->documentsGeneratorService->getDocumentData(
            entityId: $this->documentRequest->requester_entity_id,
            entityType: $this->documentRequest->requester_entity_type,
            documentType: $this->documentRequest->document_type,
            documentDataJson: $this->documentRequest->document_data_json
        );
    }

    public function print()
    {
        $barangay = auth()->user()->barangay;
        $this->documentData['barangayLogo'] = base_path('public/storage/' . $barangay->appearance_settings->logo_path);

        $viewName = '';
        switch ($this->documentType->value)
        {
            case (DocumentType::CERTIFICATE_OF_RESIDENCY->value):
                $viewName = 'certificate-of-residency';
                break;
            case (DocumentType::CERTIFICATE_OF_INDIGENCY->value):
                $viewName = 'certificate-of-indigency';
                break;
        }

        $pdf = Pdf::loadView('components.documents.templates.' . $viewName, ['previewData' => $this->documentData]);
        $this->documentData['barangayLogo'] = asset('storage/' . $barangay->appearance_settings->logo_path);

        return response()->streamDownload(function () use ($pdf)
        {
            echo $pdf->setPaper('a4')->stream();
            $this->redirectRoute('documents');
        }, $viewName . '.pdf');
    }

    public function render()
    {
        return view('livewire.documents.request-print-preview');
    }
}
