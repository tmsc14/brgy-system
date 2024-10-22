<?php

namespace App\Livewire\Login;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class LoginStaff extends Component
{
    public $email;
    public $password;

    public function boot()
    {
        $user = Auth::user();

        if ($user && $user->staff)
        {
            return redirect()->route('dashboard');
        }
        else if ($user && !$user->staff)
        {
            $this->addError('email', 'You do not have a staff record registered.');
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

            if ($user->staff && $user->staff->is_active)
            {
                return redirect()->route('dashboard');
            }
            else
            {
                $this->addError('email', 'You do not have a staff record registered.');
                Auth::logout();
            }
        }
        else
        {
            $this->addError('email', 'The provided credentials do not match our records.');
        }
    }

    public function render()
    {
        return view('livewire.login.login-staff');
    }
}
