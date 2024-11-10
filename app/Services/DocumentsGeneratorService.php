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

    public function getDocumentData(int $entityId, string $entityType, DocumentType $documentType, string $documentDataJson, string $walkInDataJson = null)
    {
        switch ($documentType)
        {
            case (DocumentType::CERTIFICATE_OF_RESIDENCY):
                return $this->getDataForCertificateOfResidency($entityId, $entityType, $documentDataJson, $walkInDataJson);
                break;
            case (DocumentType::CERTIFICATE_OF_INDIGENCY):
                return $this->getDataForCertificateOfIndigency($entityId, $entityType, $documentDataJson, $walkInDataJson);
                break;
            case (DocumentType::BUSINESS_PERMIT):
                return $this->getDataForBusinessPermit($entityId, $entityType, $documentDataJson, $walkInDataJson);
                break;
        }
    }

    protected function getDataForCertificateOfResidency(int $entityId, string $entityType, string $documentDataJson, ?string $walkInDataJson)
    {
        $barangay = auth()->user()->barangay;

        $barangayCaptain = $barangay->captain()->first();
        $barangayCaptainName = NameHelper::getReadableName($barangayCaptain->first_name, $barangayCaptain->last_name, $barangayCaptain->middle_name);
        
        $province = $this->locationService->getProvinceByProvCode($barangay->province_code)['provDesc'];
        $city = $this->locationService->getCityByCitymunCode($barangay->city_code)['citymunDesc'];
        $barangayName = $barangay->name;

        $purpose = "N/A"; // To do

        $timeNow = Carbon::now();
        $dayOfCreation = DateTimeHelper::getDayWithSuffix($timeNow->day);
        $monthOfCreation = $timeNow->format('F');
        $yearOfCreation = $timeNow->year;
        $barangayLogo = asset(
            $barangay->appearance_settings && $barangay->appearance_settings->logo_path
                ? 'storage/' . $barangay->appearance_settings->logo_path
                : 'resources/img/default-logo.png'
        );

        $userDetails = [];

        if (isset($walkInDataJson) && $entityId == 0)
        {
            $wallkInData = json_decode($walkInDataJson);

            $salutation = "";
            $fullName = $wallkInData->fullName;
            $civilStatus = $wallkInData->civilStatus;
            $gender = $wallkInData->gender;
            $address = $wallkInData->address;
            $dob = $wallkInData->dateOfBirth;

            $userDetails = compact('salutation', 'fullName', 'civilStatus', 'gender', 'address', 'dob');
        }
        else
        {
            $requester = $entityType == 'Staff'
                ? Staff::findOrFail($entityId)
                : Resident::findOrFail($entityId);

            $salutation = $requester->gender != "Male" ? "Ms." : "Mr.";
            $fullName = NameHelper::getReadableName($requester->first_name, $requester->last_name, $requester->middle_name);
            $civilStatus = "Single";
            $gender = $requester->gender;
            $dob = $requester->date_of_birth;

            $address = $barangayName . ", " . $city . ", " . $province;

            $userDetails = compact('salutation', 'fullName', 'civilStatus', 'gender', 'address', 'dob');
        }

        return array_merge(compact(
            'province',
            'city',
            'barangayName',
            'purpose',
            'dayOfCreation',
            'monthOfCreation',
            'yearOfCreation',
            'barangayCaptainName',
            'barangayLogo'
        ), $userDetails);
    }

    protected function getDataForCertificateOfIndigency(int $entityId, string $entityType, string $documentDataJson, string $walkInDataJson)
    {
        $barangay = auth()->user()->barangay;

        $barangayCaptain = $barangay->captain()->first();
        $barangayCaptainName = NameHelper::getReadableName($barangayCaptain->first_name, $barangayCaptain->last_name, $barangayCaptain->middle_name);
        
        $province = $this->locationService->getProvinceByProvCode($barangay->province_code)['provDesc'];
        $city = $this->locationService->getCityByCitymunCode($barangay->city_code)['citymunDesc'];
        $barangayName = $barangay->name;

        $purpose = "N/A"; // To do

        $timeNow = Carbon::now();
        $dayOfCreation = DateTimeHelper::getDayWithSuffix($timeNow->day);
        $monthOfCreation = $timeNow->format('F');
        $yearOfCreation = $timeNow->year;
        $barangayLogo = asset(
            $barangay->appearance_settings && $barangay->appearance_settings->logo_path
                ? 'storage/' . $barangay->appearance_settings->logo_path
                : 'resources/img/default-logo.png'
        );

        $userDetails = [];

        if (isset($walkInDataJson) && $entityId == 0)
        {
            $wallkInData = json_decode($walkInDataJson);

            $salutation = "";
            $fullName = $wallkInData->fullName;
            $dob = $wallkInData->dateOfBirth;
            $gender = $wallkInData->gender;

            $userDetails = compact('salutation', 'fullName', 'dob', 'gender');
        }
        else
        {
            $requester = $entityType == 'Staff'
                ? Staff::findOrFail($entityId)
                : Resident::findOrFail($entityId);

            $salutation = $requester->gender != "Male" ? "Ms." : "Mr.";
            $fullName = NameHelper::getReadableName($requester->first_name, $requester->last_name, $requester->middle_name);
            $dob = $requester->date_of_birth;
            $gender = $requester->gender;

            $userDetails = compact('salutation', 'fullName', 'dob', 'gender');
        }

        return array_merge(compact(
            'province',
            'city',
            'barangayName',
            'purpose',
            'dayOfCreation',
            'monthOfCreation',
            'yearOfCreation',
            'barangayCaptainName',
            'barangayLogo'
        ), $userDetails, json_decode($documentDataJson, true));
    }

    protected function getDataForBusinessPermit(int $entityId, string $entityType, string $documentDataJson, string $walkInDataJson)
    {
        $barangay = auth()->user()->barangay;

        $barangayCaptain = $barangay->captain()->first();
        $barangayCaptainName = NameHelper::getReadableName($barangayCaptain->first_name, $barangayCaptain->last_name, $barangayCaptain->middle_name);
        
        $province = $this->locationService->getProvinceByProvCode($barangay->province_code)['provDesc'];
        $city = $this->locationService->getCityByCitymunCode($barangay->city_code)['citymunDesc'];
        $barangayName = $barangay->name;

        $purpose = "N/A"; // To do

        $timeNow = Carbon::now();
        $dayOfCreation = DateTimeHelper::getDayWithSuffix($timeNow->day);
        $monthOfCreation = $timeNow->format('F');
        $yearOfCreation = $timeNow->year;
        $barangayLogo = asset(
            $barangay->appearance_settings && $barangay->appearance_settings->logo_path
                ? 'storage/' . $barangay->appearance_settings->logo_path
                : 'resources/img/default-logo.png'
        );

        $userDetails = [];

        if (isset($walkInDataJson) && $entityId == 0)
        {
            $wallkInData = json_decode($walkInDataJson);

            $fullName = $wallkInData->fullName;

            $userDetails = compact('fullName');
        }
        else
        {
            $requester = $entityType == 'Staff'
                ? Staff::findOrFail($entityId)
                : Resident::findOrFail($entityId);

            $fullName = NameHelper::getReadableName($requester->first_name, $requester->last_name, $requester->middle_name);

            $userDetails = compact('fullName');
        }

        return array_merge(compact(
            'province',
            'city',
            'barangayName',
            'purpose',
            'dayOfCreation',
            'monthOfCreation',
            'yearOfCreation',
            'barangayCaptainName',
            'barangayLogo'
        ), $userDetails, json_decode($documentDataJson, true));
    }
}
