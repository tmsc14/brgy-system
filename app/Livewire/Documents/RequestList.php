<?php

namespace App\Livewire\Documents;

use App\Models\DocumentRequest;
use App\Models\Resident;
use App\Models\Staff;
use App\Traits\DocumentRequestsListTrait;
use Livewire\Attributes\Locked;
use Livewire\Component;
use Livewire\WithoutUrlPagination;
use Livewire\WithPagination;

class RequestList extends Component
{
    #[Locked]
    public $userLoggedInAs;

    use WithPagination, WithoutUrlPagination, DocumentRequestsListTrait;

    public function mount()
    {
        $this->userLoggedInAs = auth()->user()->loggedInAs();
    }

    protected function getRequestsForStaffDisplay()
    {
        return DocumentRequest::where('status', DocumentRequest::STATUS_PENDING);
    }

    protected function getRequestsForResidentDisplay()
    {
        return DocumentRequest::where('user_id', auth()->user()->id)
            ->where('status', DocumentRequest::STATUS_PENDING);
    }

    public function preview($requestId)
    {
        $this->redirectRoute('documents.request.preview', ['id' => $requestId]);
    }

    public function deny($requestId)
    {
        DocumentRequest::find($requestId)->update(['status' => DocumentRequest::STATUS_DENIED]);
    }

    public function render()
    {
        $documentRequests = $this->userLoggedInAs === 'staff'
            ? $this->getRequestsForStaffDisplay()
            : $this->getRequestsForResidentDisplay();

        $documentRequests = $this->populateRequestNamesPaged($documentRequests);

        return view('livewire.documents.request-list', compact('documentRequests'));
    }
}
