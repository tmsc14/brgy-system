<?php

namespace App\Services;

use App\Enums\Documents\DocumentType;
use App\Helpers\DateTimeHelper;
use App\Helpers\NameHelper;
use App\Models\Resident;
use App\Models\Staff;
use App\Services\LocationService;
use Carbon\Carbon;

class DocumentsGeneratorService
{
    private LocationService $locationService;

    public function __construct(LocationService $locationService)
    {
        $this->locationService = $locationService;
    }

    public function getDocumentData(int $entityId, string $entityType, DocumentType $documentType, string $documentDataJson)
    {
        switch ($documentType)
        {
            case (DocumentType::CERTIFICATE_OF_RESIDENCY):
                    return $this->getDataForCertificateOfResidency($entityId, $entityType, $documentDataJson);
                    break;
        }
    }

    protected function getDataForCertificateOfResidency(int $entityId, string $entityType, string $documentDataJson)
    {
        $requester = $entityType == basename(Staff::class)
            ? Staff::findOrFail($entityId)
            : Resident::findOrFail($entityId);

        $barangay = $requester->barangay;

        $barangayCaptain = $barangay->captain()->first();
        $barangayCaptainName = NameHelper::getReadableName($barangayCaptain->first_name, $barangayCaptain->last_name, $barangayCaptain->middle_name);

        $province = $this->locationService->getProvinceByProvCode($barangay->province_code)['provDesc'];
        $city = $this->locationService->getCityByCitymunCode($barangay->city_code)['citymunDesc'];
        $barangayName = $barangay->name;

        $salutation = $requester->gender != "Male" ? "Ms." : "Mr.";
        $fullName = NameHelper::getReadableName($requester->first_name, $requester->last_name, $requester->middle_name);
        $dob = $requester->date_of_birth;
        $civilStatus = "Single"; // To do
        $gender = $requester->gender;
        $address = $barangayName . ", " . $city . ", " . $province; // To do, needs more details
        $purpose = "N/A"; // To do

        $timeNow = Carbon::now();
        $dayOfCreation = DateTimeHelper::getDayWithSuffix($timeNow->day);
        $monthOfCreation = $timeNow->format('F');
        $yearOfCreation = $timeNow->year;
        $barangayLogo = asset('storage/' . $barangay->appearance_settings->logo_path);

        return compact(
            'province',
            'city',
            'barangayName',
            'salutation',
            'fullName',
            'dob',
            'civilStatus',
            'gender',
            'address',
            'purpose',
            'dayOfCreation',
            'monthOfCreation',
            'yearOfCreation',
            'barangayCaptainName',
            'barangayLogo'
        );
    }
}
