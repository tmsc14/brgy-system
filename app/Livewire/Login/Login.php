<?php

namespace App\Livewire\Login;

use App\Helpers\ThemeHelper;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts/welcome')]
class Login extends Component
{
    public $role;

    public $email;
    public $password;

    public function mount($role)
    {
        $this->role = $role;
    }

    public function boot()
    {
        $user = Auth::user();

        if ($user)
        {
            switch ($this->role)
            {
                case 'staff':
                    {
                        $this->handleStaffLogin($user, false);
                        break;
                    }
                case 'resident':
                    {
                        $this->handleResidentLogin($user, false);
                        break;
                    }
            }
        }
    }

    public function login()
    {
        $credentials = $this->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials))
        {
            $user = Auth::user();

            switch ($this->role)
            {
                case 'staff':
                    {
                        $this->handleStaffLogin($user, true);
                        break;
                    }
                case 'resident':
                    {
                        $this->handleResidentLogin($user, true);
                        break;
                    }
            }
        }
        else
        {
            $this->addError('email', 'The provided credentials do not match our records.');
        }
    }

    private function handleStaffLogin($user, $shouldLogout)
    {
        if ($user->staff && $user->staff->is_active)
        {
            return $this->onLoginSuccess($user);
        }
        else
        {
            $this->addError('email', 'You do not have a staff record registered.');

            if ($shouldLogout)
            {
                Auth::logout();
            }
        }
    }

    private function handleResidentLogin($user, $shouldLogout)
    {
        if ($user->resident && $user->resident->is_active)
        {
            return $this->onLoginSuccess($user, true);
        }
        else if ($user->resident && !$user->resident->is_active)
        {
            $this->addError('email', 'Your registration request is still being reviewed.');

            if ($shouldLogout)
            {
                Auth::logout();
            }
        }
        else
        {
            $this->addError('email', 'You do not have a resident record registered.');

            if ($shouldLogout)
            {
                Auth::logout();
            }
        }
    }

    private function onLoginSuccess($user, $isResident = false)
    {
        $appearanceSettings = $user->barangay->appearance_settings;

        ThemeHelper::setSessionAppearanceSettings($appearanceSettings);
        session(['logged_in_as' => $isResident ? 'resident' : 'staff']);

        return redirect()->route('dashboard');
    }

    public function render()
    {
        return view('livewire.login.login');
    }
}
