<?php

namespace App\Traits;

use App\Models\Resident;
use App\Models\Staff;

trait DocumentRequestsListTrait
{
    public function populateRequestNamesPaged($documentRequests)
    {
        $documentRequests = $documentRequests->paginate(10);

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

        return $documentRequests;
    }
}
