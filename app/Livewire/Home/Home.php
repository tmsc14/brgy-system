<?php

namespace App\Livewire\Home;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Home extends Component
{
    public function mount()
    {
        $user = Auth::user();
        $barangay = $user->barangay;

        if (!Auth::user()->roles()->where('name', 'Captain')->exists()
            && !$barangay->is_setup_complete)
        {
            return redirect()->route('home')->with('error', 'Your barangay has not finished setting up.');
        }
        if (Auth::user()->roles()->where('name', 'Captain')->exists()
            && !$barangay->is_setup_complete)
        {
            return redirect()->route('barangay.setup');
        }
        else
        {
            return view('dashboard');
        }
    }
    
    public function render()
    {
        return view('livewire.home.home');
    }
}
