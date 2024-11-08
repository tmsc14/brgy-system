<?php

namespace App\Livewire\Documents;

use App\Enums\Documents\DocumentType;
use App\Helpers\DateTimeHelper;
use App\Helpers\NameHelper;
use App\Livewire\Forms\CertificateOfIndigencyForm;
use App\Livewire\Forms\CertificateOfResidencyRequestForm;
use App\Models\DocumentRequest;
use App\Models\Resident;
use App\Models\Staff;
use App\Models\User;
use App\Services\LocationService;
use Carbon\Carbon;
use Livewire\Attributes\Locked;
use Livewire\Component;

class RequestProfile extends Component
{
    private LocationService $locationService;

    #[Locked]
    public $previewData;

    #[Locked]
    public $documentType;

    #[Locked]
    public $availableRequesters = [];

    public $form;
    public bool $isPreviewing;
    public bool $isRequestCreated;

    public function mount($documentType)
    {
        $user = auth()->user();
        $this->documentType = DocumentType::fromValue($documentType);

        // If user is logged in as staff, they can only request for themselves.
        if ($user->loggedInAs() === 'staff')
        {
            $this->form->entity_id = $user->staff->id;
            $this->form->entity_type = basename(Staff::class);
        }

        // Staff can only request for themselves, so they are set as the entity of the request.
        if ($this->form->entity_type == basename(Staff::class))
        {
            $staff = $user->staff;
            $this->availableRequesters = [$staff->id => $staff->getFullName()];
        }
        else
        {
            $this->availableRequesters = $user->resident->household->residents
                ->mapWithKeys(function ($resident)
                {
                    return [$resident->id => $resident->getFullName()];
                })
                ->toArray();
        }

        $this->form = CertificateOfIndigencyForm::class;
    }

    public function boot(LocationService $locationService)
    {
        $this->locationService = $locationService;
    }

    public function preview()
    {
        $requester = $this->form->entity_type == basename(Staff::class)
            ? Staff::findOrFail($this->form->entity_id)
            : Resident::findOrFail($this->form->entity_id);

        $barangay = $requester->barangay;

        // Get barangay captain
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

        $this->previewData = compact(
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

        $this->isPreviewing = true;
    }

    public function request()
    {
        $user = auth()->user();

        $createResult = DocumentRequest::create([
            'barangay_id' => $user->barangay_id,
            'user_id' => $user->id,
            'requester_entity_id' => $this->form->entity_id,
            'requester_entity_type' => $this->form->entity_type,
            'document_type' => $this->documentType->value,
            'document_data_json' => json_encode($this->form->all()),
            'document_file_urls_csv' => "",
            'status' => DocumentRequest::STATUS_PENDING
        ]);

        $this->isRequestCreated = true;
    }

    public function goToDocumentsHome()
    {
        $this->redirectRoute('documents');
    }

    public function render()
    {
        return view('livewire.documents.request-profile', ['availableRequesters' => $this->availableRequesters]);
    }
}
