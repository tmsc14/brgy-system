<?php

namespace App\Livewire\Documents;

use App\Models\DocumentRequest;
use App\Models\Resident;
use App\Models\Staff;
use App\Traits\DocumentRequestsListTrait;
use Livewire\Component;
use Livewire\WithoutUrlPagination;
use Livewire\WithPagination;

class RequestHistory extends Component
{
    use WithPagination, WithoutUrlPagination, DocumentRequestsListTrait;

    protected function getRequestsForStaffDisplay()
    {
        return DocumentRequest::where('status', '!=', DocumentRequest::STATUS_PENDING);
    }

    protected function getRequestsForResidentDisplay()
    {
        return DocumentRequest::where('user_id', auth()->user()->id)
            ->where('status', '!=', DocumentRequest::STATUS_PENDING);
    }

    public function preview($requestId)
    {
        $this->redirectRoute('documents.request.preview', ['id' => $requestId]);
    }

    public function render()
    {
        $documentRequests = auth()->user()->staff
            ? $this->getRequestsForStaffDisplay()
            : $this->getRequestsForResidentDisplay();

        $documentRequests = $this->populateRequestNamesPaged($documentRequests);

        return view('livewire.documents.request-history', ['documentRequests' => $documentRequests]);
    }
}
