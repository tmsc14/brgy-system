<?php 

namespace App\Enums\Documents;

enum DocumentType: string {
    case CERTIFICATE_OF_RESIDENCY = "COR";
    case CERTIFICATE_OF_INDIGENCY = "COI";
    case BARANGAY_CLEARANCE = "BC";
    case BUSINESS_PERMIT = "BP";
    case BARANGAY_ID = "BID";
    case DEATH_CERTIFICATE = "BC";
}