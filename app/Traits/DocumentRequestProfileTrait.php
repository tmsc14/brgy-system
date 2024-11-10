<?php

namespace App\Traits;

use App\Enums\Documents\DocumentType;
use App\Models\DocumentRequest;
use App\Models\Resident;
use App\Models\Staff;
use Livewire\Attributes\Locked;
use Livewire\WithFileUploads;

trait DocumentRequestProfileTrait
{
    use WithFileUploads;

    #[Locked]
    public $previewData;

    #[Locked]
    public $availableRequesters = [];

    #[Locked]
    public $additionalFields = [];

    #[Locked]
    public $walkInFields = [];

    public bool $isPreviewing;
    public bool $isRequestCreated;

    public function preview()
    {
        $this->form->validate();

        if ($this->isWalkIn())
        {
            $this->walkInForm->validate();
        }

        $this->previewData = $this->documentsGeneratorService->getDocumentData(
            $this->form->entity_id,
            $this->form->entity_type,
            $this->documentType,
            json_encode($this->form->getAdditionalFields()),
            $this->isWalkIn() ? json_encode($this->walkInForm->all()) : ''
        );

        $this->isPreviewing = true;
    }

    public function request()
    {
        $this->form->validate();

        $user = auth()->user();

        $filePaths = [];

        if (isset($this->files))
        {
            foreach ($this->files as $file)
            {
                $filePath = $file->store(path: DocumentRequest::getFileUrlString($user->barangay->id, $user->id));
                $filePaths[] = $filePath;
            }
        }

        // Convert the file paths array to a CSV string
        $csvFilePaths = implode(',', $filePaths);

        $createResult = DocumentRequest::create([
            'barangay_id' => $user->barangay_id,
            'user_id' => $user->id,
            'requester_entity_id' => $this->form->entity_id,
            'requester_entity_type' => $this->form->entity_type,
            'document_type' => $this->documentType->value,
            'document_data_json' => json_encode($this->form->getAdditionalFields()),
            'document_file_urls_csv' => $csvFilePaths,
            'status' => DocumentRequest::STATUS_PENDING,
            'walk_in_data_json' => $this->isWalkIn() ? json_encode($this->walkInForm->all()) : ''
        ]);

        $this->isRequestCreated = true;
    }

    public function cancel()
    {
        $this->isPreviewing = false;
    }

    public function goToDocumentsHome()
    {
        $this->redirectRoute('documents');
    }

    public function render()
    {
        return view('components.documents.document-request-profile', ['availableRequesters' => $this->availableRequesters]);
    }

    protected function initializeDocumentRequestProfile(bool $isRequiresDocuments = false)
    {
        $this->setAvailableRequesters();
        $this->additionalFields = $this->form->getAdditionalFieldNames();
        $this->walkInFields = array_keys($this->walkInForm->all());

        $this->form->requires_documents = $isRequiresDocuments;
    }

    private function setAvailableRequesters()
    {
        $user = auth()->user();

        if ($user->loggedInAs() === 'staff')
        {
            $this->form->entity_id = $user->staff->id;
            $this->form->entity_type = 'Staff';
        }
        else
        {
            $this->form->entity_id = $user->resident->id;
            $this->form->entity_type = 'Resident';
        }

        if ($this->form->entity_type == 'Staff')
        {
            $this->availableRequesters = [0 => 'Walk-In'];

            $allStaff = Staff::active()->get();

            foreach ($allStaff as $staffMember) {
                $this->availableRequesters[$staffMember->id] = $staffMember->getFullName();
            }
        }
        else
        {
            $this->availableRequesters = $user->resident->household->residents
                ->mapWithKeys(function ($resident)
                {
                    return [$resident->id => $resident->getFullName()];
                })
                ->toArray();
        }
    }

    private function isWalkIn()
    {
        return $this->form->entity_id == 0;
    }
}
