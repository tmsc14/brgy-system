<?php

namespace App\Traits;


use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

trait UserSettingsTrait
{
    public $email;

    public $current_password;
    public $new_password;
    public $new_password_confirmation;

    public function mount()
    {
        $this->email = auth()->user()->email;
    }

    public function changeEmail()
    {
        $this->validateOnly('email', ['email' => ['required', 'email', Rule::unique('user', 'email')]]);

        User::find(auth()->user()->id)->update(['email' => $this->email]);

        toastr()->success('Email successfully updated.');
    }

    public function changePassword()
    {
        $this->validate([
            'current_password' => 'required',
            'new_password' => [
                'required',
                'confirmed',
                'min:8',
                'regex:/[A-Z]/',
                'regex:/[a-z]/',
                'regex:/[0-9]/',
                'regex:/[@$!%*?&#]/',
            ]
        ]);

        if (!Hash::check($this->current_password, auth()->user()->password))
        {
            $this->addError('current_password', 'The current password is incorrect.');
            return;
        }

        $user = auth()->user();
        $user->password = Hash::make($this->new_password);
        $user->save();

        toastr()->success('Your password has been successfully updated.');

        $this->reset(['current_password', 'new_password', 'new_password_confirmation']);
    }
}
