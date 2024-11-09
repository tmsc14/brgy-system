<?php

namespace App\Livewire\Register;

use App\Livewire\Forms\RegistrationForm;
use App\Livewire\Forms\ResidentFieldsForm;
use App\Models\Barangay;
use App\Services\LocationService;
use App\Services\RegistrationService;
use Illuminate\Validation\Rule;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\Features\SupportFileUploads\WithFileUploads;

#[Layout('layouts.welcome')]
class RegisterResident extends Component
{
    public $barangayOptions;
    public $selectedBarangayId;
    public RegistrationForm $form;
    public ResidentFieldsForm $residentForm;

    use WithFileUploads;

    public function mount(LocationService $locationService)
    {
        $barangays = Barangay::select('id', 'city_code', 'barangay_code')->get();

        foreach ($barangays as $barangay)
        {
            $cityName = $locationService->getCityByCitymunCode($barangay->city_code)['citymunDesc'];
            $barangayName = $locationService->getBarangayByBrgyCode($barangay->barangay_code)['brgyDesc'];

            $this->barangayOptions[] = [
                'id' => $barangay->id,
                'city_name' => $cityName,
                'barangay_name' => $barangayName,
            ];
        }
    }

    public function register()
    {
        $validateBarangay = $this->validate([
            'selectedBarangayId' => 'required'
        ]);

        $validated = $this->form->validate([
            'firstName' => 'required|alpha_spaces|min:2|max:50',
            'middleName' => 'nullable|alpha_spaces|min:2|max:50',
            'lastName' => 'required|alpha_spaces|min:2|max:50',
            'gender' => 'required|in:Male,Female,Other',
            'dateOfBirth' => 'required|date|before:today',
            'contactNumber' => ['required', 'digits_between:10,15'],
            'validId' => 'required|image',
            'email' => ['required', 'email', Rule::unique('user', 'email')],
            'password' => [
                'required',
                'confirmed',
                'min:8',
                'regex:/[A-Z]/',
                'regex:/[a-z]/',
                'regex:/[0-9]/',
                'regex:/[@$!%*?&#]/',
            ]
        ]);

        $validatedResidentForm = $this->residentForm->validate([
            'ethnicity' => 'required',
            'religion' => 'required',
            'civil_status' => 'required',
            'is_temporary_resident' => 'required',
            'is_pwd' => 'required',
            'is_voter' => 'required',
            'is_employed' => 'required',
            'is_birth_registered' => 'required',
            'is_literate' => 'required',
            'is_single_parent' => 'required',
            'street_address' => 'required'
        ]);

        if ($validateBarangay && $validated && $validatedResidentForm)
        {
            $registrationService = app(RegistrationService::class);
            $registrationService->registerResident($this->selectedBarangayId, $this->form, $this->residentForm);
        }
    }

    public function render()
    {
        return view('livewire.register.register-resident');
    }
}
