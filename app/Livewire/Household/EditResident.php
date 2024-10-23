<?php

namespace App\Livewire\Household;

use App\Models\Resident;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\Attributes\Layout;

#[Layout('layouts.app')]
class EditResident extends Component
{
    public $residentId;

    public $firstName;
    public $middleName;
    public $lastName;

    public $gender;
    public $dateOfBirth;
    public $contactNumber;
    public $bricNumber;

    public $relationship_to_head;
    public $ethnicity;
    public $religion;
    public $civil_status;
    public $is_temporary_resident;
    public $is_pwd;
    public $is_voter;
    public $is_employed;

    public function mount($id)
    {
        $residentRecord = Resident::findOrFail($id);



        $this->firstName = $residentRecord->first_name;
        $this->middleName = $residentRecord->middle_name;
        $this->lastName = $residentRecord->last_name;

        $this->gender = $residentRecord->gender;
        $this->dateOfBirth = $residentRecord->date_of_birth;
        $this->contactNumber = $residentRecord->contact_number;
        $this->bricNumber = $residentRecord->bric_number;

        $this->relationship_to_head = $residentRecord->relationship_to_head;
        $this->ethnicity = $residentRecord->ethnicity;
        $this->religion = $residentRecord->religion;
        $this->civil_status = $residentRecord->civil_status;
        $this->is_temporary_resident = $residentRecord->is_temporary_resident;
        $this->is_pwd = $residentRecord->is_pwd;
        $this->is_voter = $residentRecord->is_voter;
        $this->is_employed = $residentRecord->is_employed;
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
            'bricNumber' => 'nullable',
            'ethnicity' => 'required',
            'religion' => 'required',
            'civil_status' => 'required',
            'is_temporary_resident' => 'required',
            'is_pwd' => 'required',
            'is_voter' => 'required',
            'is_employed' => 'required',
        ]);

        $user = Auth::user();
        
        if ($validated)
        {
            $residentRecord = Resident::findOrFail($this->residentId);
            $residentRecord->update([
                'first_name' => $this->firstName,
                'middle_name' => $this->middleName,
                'last_name' => $this->lastName,
                'gender' => $this->gender,
                'contact_number' => $this->contactNumber,
                'email' => '',
                'valid_id' => '',
                'date_of_birth' => $this->dateOfBirth,
                'bric_number' => $this->bricNumber,
                'ethnicity' => $this->ethnicity,
                'religion' => $this->religion,
                'civil_status' => $this->civil_status,
                'is_temporary_resident' => $this->is_temporary_resident,
                'is_pwd' => $this->is_pwd,
                'is_voter' => $this->is_voter,
                'is_employed' => $this->is_employed
            ]);

            $this->redirectRoute('household');
        }
    }

    public function render()
    {
        return view('livewire.household.edit-resident');
    }
}