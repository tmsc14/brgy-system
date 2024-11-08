<?php 

namespace App\Enums\Documents;

enum DocumentType: string 
{
    case CERTIFICATE_OF_RESIDENCY = "CERTIFICATE_OF_RESIDENCY";
    case CERTIFICATE_OF_INDIGENCY = "CERTIFICATE_OF_INDIGENCY";
    case BARANGAY_CLEARANCE = "BARANGAY_CLEARANCE";
    case BUSINESS_PERMIT = "BUSINESS_PERMIT";
    case BARANGAY_ID = "BARANGAY_ID";
    case DEATH_CERTIFICATE = "DEATH_CERTIFICATE";

    public function getDescription(): string
    {
        return match ($this) {
            self::CERTIFICATE_OF_RESIDENCY => "Certificate of Residency",
            self::CERTIFICATE_OF_INDIGENCY => "Certificate of Indigency",
            self::BARANGAY_CLEARANCE => "Barangay Clearance",
            self::BUSINESS_PERMIT => "Business Permit",
            self::BARANGAY_ID => "Barangay ID",
            self::DEATH_CERTIFICATE => "Death Certificate",
        };
    }

    public function getViewName(): string
    {
        return match ($this) {
            self::CERTIFICATE_OF_RESIDENCY => "certificate-of-residency",
            self::CERTIFICATE_OF_INDIGENCY => "certificate-of-indigency",
            self::BARANGAY_CLEARANCE => "barangay-clearance",
            self::BUSINESS_PERMIT => "business-permit",
            self::BARANGAY_ID => "barangay-id",
            self::DEATH_CERTIFICATE => "death-certificate",
        };
    }

    public static function fromValue(string $value): ?self
    {
        return self::from($value);
    }
}