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
            return redirect()->route('appHome');
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

            if ($user->staff)
            {
                return redirect()->route('appHome');
            }
            else
            {
                $this->addError('email', 'You do not have a staff record registered.');
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
