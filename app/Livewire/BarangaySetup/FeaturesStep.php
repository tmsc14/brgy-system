<?php

namespace App\Livewire\BarangaySetup;

use Livewire\Component;
use Spatie\LivewireWizard\Components\StepComponent;

class FeaturesStep extends StepComponent
{
    public function stepInfo(): array
    {
        return [
            'label' => 'Features',
            'order' => '3',
            'step_name' => 'barangay-setup.features-step',
        ];
    }

    public function render()
    {
        return view('livewire.barangay-setup.features-step');
    }
}
