<?php

namespace App\Livewire\Register;

use Spatie\LivewireWizard\Components\StepComponent;
use Illuminate\Validation\Rule;
use Livewire\WithFileUploads;

class UserDetailsStep extends StepComponent
{
    public $firstName;
    public $middleName;
    public $lastName;

    public $gender;
    public $dateOfBirth;
    public $contactNumber;
    public $bricNumber;

    public $validId;
    public $email;
    public $password;
    public $confirmPassword;
    public $accessCode;

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
        $validated = $this->validate([
            'firstName' => 'required|alpha_spaces|min:2|max:50',
            'middleName' => 'nullable|alpha_spaces|min:2|max:50',
            'lastName' => 'required|alpha_spaces|min:2|max:50',
            'gender' => 'required|in:Male,Female,Other',
            'dateOfBirth' => 'required|date|before:today',
            'contactNumber' => ['required', 'digits_between:10,15'],
            'bricNumber' => 'nullable',
            'validId' => 'required|image',
            'email' => ['required', 'email', Rule::unique('user', 'email')],
            'password' => 'required',
            'confirmPassword' => 'required',
            'accessCode' => 'required'
        ]);

        $barangaySelectionState = $this->state()->forStep('barangay-selection-step');

        
    }
}
