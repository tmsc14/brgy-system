<?php

namespace App\Livewire\Documents;

use App\Models\DocumentRequest;
use App\Models\Resident;
use App\Models\Staff;
use Livewire\Component;
use Livewire\WithoutUrlPagination;
use Livewire\WithPagination;

class RequestList extends Component
{
    use WithPagination, WithoutUrlPagination;

    public function preview($requestId)
    {
        $this->redirectRoute('documents.request.preview', ['id' => $requestId]);
    }

    public function render()
    {
        $documentRequests = DocumentRequest::paginate(4);

        foreach ($documentRequests as $documentRequest)
        {
            if ($documentRequest->requester_entity_type === 'Staff')
            {
                $entity = Staff::find($documentRequest->requester_entity_id);
                $documentRequest->name = $entity->getFullName();
            }
            elseif ($documentRequest->requester_entity_type === 'Resident')
            {
                $entity = Resident::find($documentRequest->requester_entity_id);
                $documentRequest->name = $entity->getFullName();
            }
        }

        return view('livewire.documents.request-list', compact('documentRequests'));
    }
}
