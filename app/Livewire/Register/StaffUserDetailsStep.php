<?php

namespace App\Livewire\Register;

use App\Livewire\Forms\RegistrationForm;
use App\Livewire\Forms\StaffRegistrationFieldsForm;
use App\Services\RegistrationService;
use Spatie\LivewireWizard\Components\StepComponent;
use Illuminate\Validation\Rule;
use Livewire\WithFileUploads;

class StaffUserDetailsStep extends StepComponent
{
    public $role;
    public RegistrationForm $form;

    public StaffRegistrationFieldsForm $staffForm;

    use WithFileUploads;

    public function stepInfo(): array
    {
        return [
            'label' => 'Staff Details',
            'order' => '2'
        ];
    }

    public function register()
    {
        $hasRole = $this->validate([
            'role' => 'required|in:Staff,Official'
        ]);

        $validated = $this->form->validate([
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
            ],
            'accessCode' => 'required'
        ]);

        if ($hasRole && $validated)
        {
            switch ($this->role)
            {
                case ('Staff'):
                    {
                        $staffValidated = $this->staffForm->validate([
                            'staffRole' => 'required'
                        ]);

                        if ($staffValidated)
                        {
                            $barangaySelectionState = $this->state()->forStep('register.barangay-selection-step');
                            $registrationService = app(RegistrationService::class);
                        }
                        break;
                    }
                case ('Official'):
                    {
                        break;
                    }
            }

            $registrationService->initializeBarangayAndCaptain($barangaySelectionState['selectedBarangayCode'], $this->form);
        }
    }

    public function render()
    {
        return view('livewire.register.staff-user-details-step');
    }
}
