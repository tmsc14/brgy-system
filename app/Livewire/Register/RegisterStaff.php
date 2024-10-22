<?php

namespace App\Livewire\Register;

use App\Livewire\Forms\RegistrationForm;
use App\Livewire\Forms\StaffRegistrationFieldsForm;
use App\Models\Barangay;
use App\Services\LocationService;
use App\Services\RegistrationService;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Validation\Rule;

class RegisterStaff extends Component
{
    public $title = "Staff";
    public $barangayOptions;
    public $role;

    public RegistrationForm $form;
    public StaffRegistrationFieldsForm $staffForm;

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
        $validatedStaffFields = $this->staffForm->validate([
            'selectedBarangayId' => 'required'
        ]);

        $validatedRole = $this->validate([
            'role' => 'required'
        ]);

        $validatedRegistrationForm = $this->form->validate([
            'firstName' => 'required|alpha_spaces|min:2|max:50',
            'middleName' => 'nullable|alpha_spaces|min:2|max:50',
            'lastName' => 'required|alpha_spaces|min:2|max:50',
            'gender' => 'required|in:Male,Female,Other',
            'dateOfBirth' => 'required|date|before:today',
            'contactNumber' => ['required', 'digits_between:10,15'],
            'bricNumber' => 'nullable',
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

        if ($validatedRole && $validatedRegistrationForm && $validatedStaffFields)
        {
            $registrationService = app(RegistrationService::class);
            $registrationService->registerStaff($this->role, $this->form, $this->staffForm);
        }
    }

    public function render()
    {
        return view('livewire.register.register-staff');
    }
}
