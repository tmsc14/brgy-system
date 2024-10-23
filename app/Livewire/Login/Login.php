<?php

namespace App\Livewire\Login;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;

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
            return redirect()->route('dashboard');
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
            return redirect()->route('dashboard');
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

    public function render()
    {
        return view('livewire.login.login');
    }
}
