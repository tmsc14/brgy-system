<?php

namespace App\Livewire\Settings;

use App\Models\Role;
use App\Models\User;
use App\Traits\UserSettingsTrait;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Livewire\Attributes\Validate;
use Livewire\Component;

class StaffAccountSettings extends Component
{
    public $new_captain_email;
    public $captain_password;

    use UserSettingsTrait;

    public function turnover()
    {
        $this->validate([
            'new_captain_email' => ['required', 'email']
        ]);

        $new_captain = User::where('email', $this->new_captain_email)->first();

        if (!$new_captain || !$new_captain->staff)
        {
            $this->addError('new_captain_email', 'No staff record exists that is registered with this email.');
            return;
        }

        if (!$new_captain->staff->is_active)
        {
            $this->addError('new_captain_email', 'The user is currently inactive.');
            return;
        }

        if ($new_captain->is_master)
        {
            $this->addError('new_captain_email', 'The user that is associated with this email is already the system administrator.');
            return;
        }

        if (!Hash::check($this->captain_password, auth()->user()->password))
        {
            $this->addError('captain_password', 'The current password is incorrect.');
            return;
        }

        $user = auth()->user();
        $captainRole = Role::where('barangay_id', $user->barangay->id)->where('name', 'Captain')->first();
        $staffRole = Role::where('barangay_id', $user->barangay->id)->where('name', 'Staff')->first();

        $user->staff->is_master = false;
        $user->roles()->detach();
        $user->roles()->attach($staffRole, ['barangay_id' => $user->barangay->id]);
        $user->staff->position = 'Manager';
        $user->staff->title = 'Staff';
        $user->staff->save();

        $new_captain->staff->is_master = true;
        $new_captain->roles()->detach();
        $new_captain->roles()->attach($captainRole, ['barangay_id' => $user->barangay->id]);
        $new_captain->staff->position = null;
        $new_captain->staff->title = 'Captain';
        $new_captain->staff->save();

        toastr()->success('Turnover successful! You have been logged out as Barangay Captain.');
        $this->redirectRoute('login', ['role' => 'Staff']);
    }

    public function render()
    {
        return view('livewire.settings.staff-account-settings');
    }
}
