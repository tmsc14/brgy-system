<?php

namespace App\Livewire\BarangaySetup;

use App\Services\LocationService;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Spatie\LivewireWizard\Components\StepComponent;

class BarangayInformationStep extends StepComponent
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
    public $barangay_office_address;
    #[Session]
    public $description;
    #[Session]
    public $contact_number;

    public function mount()
    {
        $barangay = Auth::user()->barangay;
        $this->display_name = $barangay->display_name;
        $this->email = $barangay->email;

        $this->address_line_one = $barangay->address_line_one;
        $this->address_line_two = $barangay->address_line_two;
        $this->barangay_office_address = $barangay->barangay_office_address;
        $this->description = $barangay->description;
        $this->contact_number = $barangay->contact_number;
    }

    public function save()
    {
        $isValidated = $this->validate([
            'display_name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'address_line_one' => 'required|string|max:255',
            'address_line_two' => 'nullable|string|max:255',
            'barangay_office_address' => 'required|string|max:255',
            'description' => 'required|string',
            'contact_number' => 'required|string|max:255',
        ]);
        
        if ($isValidated)
        {
            $barangay = Auth::user()->barangay;
            $barangay->update($this->all());
            $this->nextStep();
        }
    }

    public function stepInfo(): array
    {
        return [
            'label' => 'Barangay Information',
            'order' => '1',
            'step_name' => 'barangay-setup.barangay-information-step',
        ];
    }

    public function render()
    {
        return view('livewire.barangay-setup.barangay-information-step');
    }
}
