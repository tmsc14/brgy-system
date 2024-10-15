<?php

namespace App\Livewire\BarangaySetup;

use Spatie\LivewireWizard\Components\WizardComponent;

class BarangaySetupWizard extends WizardComponent
{
    public function steps(): array
    {
        return [
            BarangayInformationStep::class,
            AppearancesStep::class,
            FeaturesStep::class
        ];
    }
}