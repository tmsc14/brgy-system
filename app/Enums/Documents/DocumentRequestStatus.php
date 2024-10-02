<?php

namespace App\Enums\Documents;

enum DocumentRequestStatus
{
    case PENDING;
    case APPROVED;
    case DENIED;
}
