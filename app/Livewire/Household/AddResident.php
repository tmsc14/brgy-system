<?php

namespace App\Livewire\Household;

use App\Models\Resident;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Locked;

class AddResident extends Component
{
    #[Locked]
    public $householdId;

    public $firstName;
    public $middleName;
    public $lastName;

    public $gender;
    public $dateOfBirth;
    public $contactNumber;

    public $relationship_to_head;
    public $ethnicity;
    public $religion;
    public $civil_status;
    public $is_temporary_resident;
    public $is_pwd;
    public $is_voter;
    public $is_employed;
    public $is_birth_registered;
    public $is_literate;
    public $is_single_parent;

    public function mount($householdId)
    {
        $this->householdId = $householdId;
    }

    public function save()
    {
        $validated = $this->validate([
            'firstName' => 'required|alpha_spaces|min:2|max:50',
            'middleName' => 'nullable|alpha_spaces|min:2|max:50',
            'lastName' => 'required|alpha_spaces|min:2|max:50',
            'gender' => 'required|in:Male,Female,Other',
            'dateOfBirth' => 'required|date|before:today',
            'contactNumber' => ['required', 'digits_between:10,15'],
            'ethnicity' => 'required',
            'religion' => 'required',
            'civil_status' => 'required',
            'is_temporary_resident' => 'required',
            'is_pwd' => 'required',
            'is_voter' => 'required',
            'is_employed' => 'required',
            'is_birth_registered' => 'required',
            'is_literate' => 'required',
            'is_single_parent' => 'required'
        ]);

        $user = Auth::user();

        if ($validated)
        {
            Resident::create([
                'barangay_id' => $user->barangay->id,
                'household_id' => $this->householdId,
                'first_name' => $this->firstName,
                'middle_name' => $this->middleName,
                'last_name' => $this->lastName,
                'gender' => $this->gender,
                'contact_number' => $this->contactNumber,
                'email' => '',
                'valid_id' => '',
                'date_of_birth' => $this->dateOfBirth,
                'is_head_of_household' => false,
                'ethnicity' => $this->ethnicity,
                'religion' => $this->religion,
                'civil_status' => $this->civil_status,
                'is_temporary_resident' => $this->is_temporary_resident,
                'is_pwd' => $this->is_pwd,
                'is_voter' => $this->is_voter,
                'is_employed' => $this->is_employed,
                'is_active' => true,
                'is_birth_registered' => $this->is_birth_registered,
                'is_literate' => $this->is_literate,
                'is_single_parent' => $this->is_single_parent
            ]);

            $this->redirectRoute('household.view', ['id' => $this->householdId]);
        }
    }

    public function render()
    {
        return view('livewire.household.add-resident');
    }
}
