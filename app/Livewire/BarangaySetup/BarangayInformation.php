<?php

namespace App\Livewire\BarangaySetup;

use App\Services\LocationService;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Session;
use Livewire\Component;

class BarangayInformation extends Component
{
    #[Session]
    public $display_name;
    #[Session]
    public $email;

    #[Session]
    public $address_line_one;
    #[Session]
    public $address_line_two;
    #[Session]
    public $contact_number;

    public $is_wizard_step;

    public function mount($is_wizard_step = false)
    {
        $barangay = Auth::user()->barangay;
        $this->display_name = $barangay->display_name;
        $this->email = $barangay->email;

        $this->address_line_one = $barangay->address_line_one;
        $this->address_line_two = $barangay->address_line_two;
        $this->contact_number = $barangay->contact_number;

        $this->is_wizard_step = $is_wizard_step;
    }

    public function save()
    {
        $isValidated = $this->validate([
            'display_name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'address_line_one' => 'required|string|max:255',
            'address_line_two' => 'nullable|string|max:255',
            'contact_number' => 'required|string|max:255',
        ]);
        
        if ($isValidated)
        {
            $barangay = Auth::user()->barangay;
            $barangay->update($this->all());

            if ($this->is_wizard_step)
            {
                $this->dispatch('nextWizardStep');
            }
        }
    }

    public function render()
    {
        return view('livewire.barangay-setup.barangay-information');
    }
}
