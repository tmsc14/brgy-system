<?php

namespace App\Livewire\Register;

use App\Livewire\Forms\RegistrationForm;
use App\Services\RegistrationService;
use Spatie\LivewireWizard\Components\StepComponent;
use Illuminate\Validation\Rule;
use Livewire\WithFileUploads;

class UserDetailsStep extends StepComponent
{
    public RegistrationForm $form;

    use WithFileUploads;

    public function stepInfo(): array
    {
        return [
            'label' => 'Barangay Captain Details',
            'order' => '2'
        ];
    }

    public function render()
    {
        return view('livewire.register.user-details-step');
    }

    public function register()
    {
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
            ],
            'accessCode' => 'required'
        ]);

        if ($validated)
        {
            $barangaySelectionState = $this->state()->forStep('register.barangay-selection-step');
            $registrationService = app(RegistrationService::class);
            $registrationService->initializeBarangayAndCaptain($barangaySelectionState['selectedBarangayCode'], $this->form);
        }
    }
}
