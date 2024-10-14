<?php

namespace App\Livewire\Register;

use Spatie\LivewireWizard\Components\WizardComponent;

class RegisterWizard extends WizardComponent
{
    public function steps(): array
    {
        return [
            BarangaySelectionStep::class
        ];
    }
}