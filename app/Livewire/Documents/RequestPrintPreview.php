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
            documentType: $this->documentType,
            documentDataJson: $this->documentRequest->document_data_json
        );
    }

    public function cancel()
    {
        $this->redirectRoute('documents.request-list');
    }

    public function print()
    {
        $barangay = auth()->user()->barangay;
        $this->documentData['barangayLogo'] = $barangay->appearance_settings->logo_path
            ? base_path('public/storage/' . $barangay->appearance_settings->logo_path)
            : base_path('public/resources/img/default-logo.png');
        $viewName = $this->documentType->getViewName();

        $pdf = Pdf::loadView('components.documents.templates.' . $viewName, ['previewData' => $this->documentData]);
        $this->documentData['barangayLogo'] = asset('storage/' . $barangay->appearance_settings->logo_path);

        return response()->streamDownload(function () use ($pdf) {
            echo $pdf->setPaper('a4')->stream();
            $this->documentRequest->update(['status' => DocumentRequest::STATUS_RELEASED]);
            $this->redirectRoute('documents.request-list');
        }, $viewName . '.pdf');
    }

    public function render()
    {
        return view('livewire.documents.request-print-preview');
    }
}
