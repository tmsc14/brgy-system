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
                if ($documentRequest->requester_entity_id == 0)
                {
                    $documentRequest->name = json_decode($documentRequest->walk_in_data_json)->fullName;
                }
                else
                {
                    $entity = Staff::find($documentRequest->requester_entity_id);
                    $documentRequest->name = isset($entity) ? $entity->getFullName() : 'N/A';
                }
            }
            elseif ($documentRequest->requester_entity_type === 'Resident')
            {
                $entity = Resident::find($documentRequest->requester_entity_id);
                $documentRequest->name = isset($entity) ? $entity->getFullName() : 'N/A';
            }
        }

        return $documentRequests;
    }
}
