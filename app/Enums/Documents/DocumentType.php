<?php 

namespace App\Enums\Documents;

enum DocumentType: string 
{
    case CERTIFICATE_OF_RESIDENCY = "CERTIFICATE_OF_RESIDENCY";
    case CERTIFICATE_OF_INDIGENCY = "CERTIFICATE_OF_INDIGENCY";
    case BUSINESS_PERMIT = "BUSINESS_PERMIT";

    public function getDescription(): string
    {
        return match ($this) {
            self::CERTIFICATE_OF_RESIDENCY => "Certificate of Residency",
            self::CERTIFICATE_OF_INDIGENCY => "Certificate of Indigency",
            self::BUSINESS_PERMIT => "Business Permit",
        };
    }

    public function getViewName(): string
    {
        return match ($this) {
            self::CERTIFICATE_OF_RESIDENCY => "certificate-of-residency",
            self::CERTIFICATE_OF_INDIGENCY => "certificate-of-indigency",
            self::BUSINESS_PERMIT => "business-permit",
        };
    }

    public static function fromValue(string $value): ?self
    {
        return self::from($value);
    }
}