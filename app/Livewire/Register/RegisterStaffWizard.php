<?php

namespace App\Livewire\Register;

use App\Livewire\Register\StaffUserDetailsStep;
use Spatie\LivewireWizard\Components\WizardComponent;

class RegisterStaffWizard extends WizardComponent
{
    public function steps(): array
    {
        return [
            BarangaySelectionStep::class,
            StaffUserDetailsStep::class
        ];
    }
}