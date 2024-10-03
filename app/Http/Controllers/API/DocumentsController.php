<?php

namespace App\Http\Controllers\API;

use App\Enums\Documents\DocumentRequestStatus;
use App\Enums\Documents\DocumentType;
use App\Helpers\DateTimeHelper;
use App\Helpers\NameHelper;
use App\Models\DocumentRequest;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Carbon;
use Spatie\LaravelPdf\Facades\Pdf;

use function Laravel\Prompts\error;

class DocumentsController extends Controller
{
    public function showBarangayOfficialDocuments()
    {
        $user = Auth::guard('barangay_official')->user();
        $barangay = $user->barangay;
        $appearanceSettings = $user->barangay ? $user->barangay->appearanceSettings : null;

        $role = 'barangay_official';
        return view('barangay_official.documents.bo-documents', compact('user', 'appearanceSettings', 'role', 'barangay'));
    }

    public function listDocumentRequests()
    {
        $user = Auth::guard('barangay_official')->user();
        $barangay = $user->barangay;
        $appearanceSettings = $user->barangay ? $user->barangay->appearanceSettings : null;

        $documentRequests = DB::table('document_requests')
            ->where('barangay_id', $barangay->id)
            ->select('id', 'document_owner_name', 'document_type', 'created_at')
            ->get();

        $role = 'barangay_official';
        return view('barangay_official.documents.bo-documents-request-list', compact('user', 'appearanceSettings', 'role', 'barangay', 'documentRequests'));
    }

    public function listDocumentRequestTypes()
    {
        $user = Auth::guard('barangay_resident')->user();
        $barangay = $user->barangay;
        $appearanceSettings = $user->barangay ? $user->barangay->appearanceSettings : null;
        $documentRequestTypes = DocumentType::cases();

        $role = 'barangay_resident';
        return view('barangay_resident.documents.br-documents', compact('user', 'appearanceSettings', 'role', 'barangay', 'documentRequestTypes'));
    }

    public function previewCertificateOfResidencyForBarangayOfficial()
    {
        $user = Auth::guard('barangay_official')->user();
        $barangay = $user->barangay;
        $appearanceSettings = $user->barangay ? $user->barangay->appearanceSettings : null;
        $documentType = DocumentType::CERTIFICATE_OF_RESIDENCY;

        $jsonData = DB::table('document_requests')
            ->where('barangay_id', $barangay->id)
            ->where('id', request('id'))
            ->select('document_data_json')
            ->first();

        $data = json_decode($jsonData->document_data_json);
        
        $province = $data->province;
        $city = $data->city;
        $barangayName = $data->barangayName;
        $salutation = $data->salutation;
        $fullName = $data->fullName;
        $dob = $data->dob;
        $civilStatus = $data->civilStatus;
        $gender = $data->gender;
        $address = $data->address;
        $purpose = $data->purpose;
        $dayOfCreation = $data->dayOfCreation;
        $monthOfCreation = $data->monthOfCreation;
        $yearOfCreation = $data->yearOfCreation;
        $barangayCaptainName = $data->barangayCaptainName;
        $requestId = request('id');

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
                'barangayCaptainName',
                'requestId'
            ];

        $role = 'barangay_official';
        return view('barangay_official.documents.bo-documents-preview', compact('user', 'appearanceSettings', 'role', 'barangay', 'documentType', $supplementalData));
    }

    public function generatePdfCertificateOfResidencyForBarangayOfficial()
    {
        $user = Auth::guard('barangay_official')->user();
        $barangay = $user->barangay;
        $appearanceSettings = $user->barangay ? $user->barangay->appearanceSettings : null;
        $documentType = DocumentType::CERTIFICATE_OF_RESIDENCY;

        $jsonData = DB::table('document_requests')
            ->where('barangay_id', $barangay->id)
            ->where('id', request('id'))
            ->select('document_data_json')
            ->first();

        $data = json_decode($jsonData->document_data_json);
        
        $province = $data->province;
        $city = $data->city;
        $barangayName = $data->barangayName;
        $salutation = $data->salutation;
        $fullName = $data->fullName;
        $dob = $data->dob;
        $civilStatus = $data->civilStatus;
        $gender = $data->gender;
        $address = $data->address;
        $purpose = $data->purpose;
        $dayOfCreation = $data->dayOfCreation;
        $monthOfCreation = $data->monthOfCreation;
        $yearOfCreation = $data->yearOfCreation;
        $barangayCaptainName = $data->barangayCaptainName;

        $supplementalData =
            [
                'province' => $province,
                'city' => $city,
                'barangayName' => $barangayName,
                'salutation' => $salutation,
                'fullName' => $fullName,
                'dob' => $dob,
                'civilStatus' => $civilStatus,
                'gender' => $gender,
                'address' => $address,
                'purpose' => $purpose,
                'dayOfCreation' => $dayOfCreation,
                'monthOfCreation' => $monthOfCreation,
                'yearOfCreation' => $yearOfCreation,
                'barangayCaptainName' => $barangayCaptainName
            ];

            $pdf = PDF::view('document_templates.certificate-of-residency', $supplementalData)
                ->format('a4')
                ->name('certificate-of-residency.pdf');
                

        return $pdf;
    }

    public function previewCertificateOfResidency()
    {
        $user = Auth::guard('barangay_resident')->user();
        $barangay = $user->barangay;
        $appearanceSettings = $user->barangay ? $user->barangay->appearanceSettings : null;
        $documentType = DocumentType::CERTIFICATE_OF_RESIDENCY;

        // Get barangay captain
        $barangayCaptain = DB::table('barangay_captains')
            ->select('first_name', 'middle_name', 'last_name')
            ->where('id', $barangay->barangay_captain_id)
            ->first();

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
        $barangayName = $barangay->barangay_name;

        $salutation = $user->gender != "Male" ? "Ms." : "Mr.";
        $fullName = NameHelper::getReadableName($user->first_name, $user->last_name, $user->middle_name);
        $dob = $user->dob;
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

        $role = 'barangay_resident';
        return view('barangay_resident.documents.br-documents-preview', compact('user', 'appearanceSettings', 'role', 'barangay', 'documentType', $supplementalData));
    }

    public function createDocumentRequest()
    {
        $user = Auth::guard('barangay_resident')->user();

        $documentType = DocumentType::fromValue(request('data')['documentType']);

        $createResult = DocumentRequest::create([
            'barangay_id' => $user->barangay_id,
            'resident_id' => $user->id,
            'document_owner_name' => NameHelper::getReadableName($user->first_name, $user->last_name, $user->middle_name),
            'document_type' => $documentType,
            'document_data_json' => json_encode(request('data')),
            'document_file_urls_csv' => "",
            'status' => DocumentRequestStatus::PENDING->value
        ]);
        return response()->json($createResult, 200);
    }

    public function showCertificateOfResidencyRequestSuccess()
    {
        $user = Auth::guard('barangay_resident')->user();
        $barangay = $user->barangay;
        $appearanceSettings = $user->barangay ? $user->barangay->appearanceSettings : null;
        $documentType = DocumentType::CERTIFICATE_OF_RESIDENCY->getDescription();

        $role = 'barangay_resident';
        return view('barangay_resident.documents.br-documents-success', compact('user', 'appearanceSettings', 'role', 'barangay', 'documentType'));
    }
}
