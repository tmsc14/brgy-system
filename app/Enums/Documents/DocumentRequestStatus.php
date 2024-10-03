<?php

namespace App\Enums\Documents;

enum DocumentRequestStatus: string
{
    case PENDING = "PENDING";
    case APPROVED = "APPROVED";
    case DENIED = "DENIED";
}
