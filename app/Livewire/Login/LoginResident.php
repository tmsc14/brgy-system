<?php

namespace App\Livewire\Login;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class LoginResident extends Component
{
    public $email;
    public $password;

    public function boot()
    {
        $user = Auth::user();

        if ($user && $user->resident)
        {
            return redirect()->route('dashboard');
        }
        else if ($user && !$user->resident)
        {
            $this->addError('email', 'You do not have a resident record registered.');
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

            if ($user->resident && $user->resident->is_active)
            {
                return redirect()->route('dashboard');
            }
            else if ($user->resident && !$user->resident->is_active)
            {
                $this->addError('email', 'Your registration request is still being reviewed.');
                Auth::logout();
            }
            else
            {
                $this->addError('email', 'You do not have a resident record registered.');
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
        return view('livewire.login.login-resident');
    }
}
