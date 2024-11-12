<?php

namespace App\Livewire\BarangaySetup;

use Spatie\LivewireWizard\Components\StepComponent;

class AppearancesStep extends StepComponent
{
    public function stepInfo(): array
    {
        return [
            'label' => 'Appearances',
            'order' => '2',
            'step_name' => 'barangay-setup.appearances-step',
        ];
    }

    public function render()
    {
        return view('livewire.barangay-setup.appearances-step');
    }

    public function goToNextStep()
    {
        $this->nextStep();
    }
}
