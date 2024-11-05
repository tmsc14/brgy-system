<?php

namespace App\Livewire\Documents;

use App\Enums\Documents\DocumentType;
use App\Helpers\DateTimeHelper;
use App\Helpers\NameHelper;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Livewire\Component;

class CertificateOfResidency extends Component
{
    public $documentType = DocumentType::CERTIFICATE_OF_RESIDENCY;

    public function render()
    {
        $user = Auth::user()->resident ?? Auth::user()->staff;
        $barangay = Auth::user()->barangay;

        // Get barangay captain
        $barangayCaptain = $barangay->captain()->first();

        $barangayCaptainName = NameHelper::getReadableName($barangayCaptain->first_name, $barangayCaptain->last_name, $barangayCaptain->middle_name);

        // Get province from json file
        $filePath = base_path('public/json/refprovince.json');
        $jsonContent = File::get($filePath);
        $provinces = json_decode($jsonContent, true);

        $userProvinceCode = $barangay->province;
        $province = null;

        // Loop through the RECORDS to find the matching provCode
        foreach ($provinces['RECORDS'] as $record)
        {
            if ($record['provCode'] === $userProvinceCode)
            {
                $province = $record['provDesc'];
                break; // Stop the loop once we find the match
            }
        }

        // Do it again for city
        $cityFilePath = base_path('public/json/refcitymun.json');
        $cityJsonContent = File::get($cityFilePath);
        $cities = json_decode($cityJsonContent, true);

        $userCityCode = $barangay->city;
        $city = null;

        // Loop through the RECORDS to find the matching cityMunCode
        foreach ($cities['RECORDS'] as $record)
        {
            if ($record['citymunCode'] === $userCityCode)
            {
                $city = $record['citymunDesc'];
                break; // Stop the loop once we find the match
            }
        }

        // Barangay name is already stored, so just get from model (should be this way for city and provi)
        $barangayName = $barangay->name;

        $salutation = $user->gender != "Male" ? "Ms." : "Mr.";
        $fullName = NameHelper::getReadableName($user->first_name, $user->last_name, $user->middle_name);
        $dob = $user->date_of_birth;
        $civilStatus = "Single"; // To do
        $gender = $user->gender;
        $address = $barangayName . ", " . $city . ", " . $province; // To do, needs more details
        $purpose = "N/A"; // To do

        $timeNow = Carbon::now();
        $dayOfCreation = DateTimeHelper::getDayWithSuffix($timeNow->day);
        $monthOfCreation = $timeNow->format('F');
        $yearOfCreation = $timeNow->year;

        $supplementalData =
            [
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
                'barangayCaptainName'
            ];

        return view('livewire.documents.certificate-of-residency', compact($supplementalData));
    }
}
