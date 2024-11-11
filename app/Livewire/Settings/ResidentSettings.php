<?php

namespace App\Livewire\Settings;

use App\Models\Resident;
use App\Models\Role;
use App\Models\User;
use App\Models\UserRole;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Livewire\Attributes\Validate;
use Livewire\Component;

class ResidentSettings extends Component
{
    public $household_residents;

    public $contact_number;

    public $newHeadResidentId;

    public $email;
    public $password;
    public $password_confirmation;

    public $show_fields = true;

    public function mount()
    {
        $this->contact_number = Resident::find(auth()->user()->resident->id)->contact_number;

        $this->household_residents = auth()->user()->resident->household->residents
            ->reject(function ($resident)
            {
                return $resident->id === auth()->user()->resident->id;
            })
            ->mapWithKeys(function ($resident)
            {
                return [$resident->id => $resident->getFullName()];
            })
            ->toArray();
    }

    public function updatedNewHeadResidentId($value)
    {
        $newHeadResidentRecord = Resident::find($value);
        
        if ($newHeadResidentRecord && $newHeadResidentRecord->user_id)
        {
            $this->show_fields = false;
        }
    }

    public function updateProfile()
    {
        $this->validate([
            'contact_number' => ['required', 'digits_between:10,15']
        ]);

        Resident::find(auth()->user()->resident->id)->contact_number = $this->contact_number;

        toastr()->success('Profile details updated successfully.');
    }

    public function turnover()
    {
        $newHeadResidentRecord = Resident::find($this->newHeadResidentId);

        if ($newHeadResidentRecord && $newHeadResidentRecord->user_id)
        {
            $newHeadResidentRecord->update(['is_head_of_household' => true]);
            Resident::find(auth()->user()->resident->id)->update(['is_head_of_household' => false]);

            Auth::logout();
            $this->redirectRoute('login', ['role' => 'resident']);
            return;
        }

        $this->validate([
            'newHeadResidentId' => 'required',
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

        $barangayId = auth()->user()->barangay->id;

        $user = User::create([
            'barangay_id' => $barangayId,
            'email' => $this->email,
            'email_verified_at' => now('UTC'),
            'password' => Hash::make($this->password)
        ]);

        Resident::find($this->newHeadResidentId)->update(['user_id' => $user->id, 'is_active' => true, 'is_head_of_household' => true]);
        Resident::find(auth()->user()->resident->id)->update(['is_head_of_household' => false]);

        $role = Role::where('barangay_id', $barangayId)->where('name', 'Resident')->first();

        UserRole::create([
            'barangay_id' => $barangayId,
            'user_id' => $user->id,
            'role_id' => $role->id
        ]);

        toastr()->success('Turnover successful.');
        Auth::logout();
        $this->redirectRoute('login', ['role' => 'resident']);
    }

    public function render()
    {
        return view('livewire.settings.resident-settings');
    }
}
