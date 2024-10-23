<?php

namespace App\Livewire\BarangaySetup;

use Livewire\Attributes\On;
use Spatie\LivewireWizard\Components\StepComponent;

class BarangayInformationStep extends StepComponent
{

    #[On('post-created')] 
    public function goToNextStep()
    {
        $this->nextStep();
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
