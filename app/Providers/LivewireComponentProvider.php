<?php

namespace App\Providers;

use App\Livewire\BarangaySetup\BarangayInformationStep;
use App\Livewire\BarangaySetup\BarangaySetupWizard;
use Illuminate\Support\ServiceProvider;
use App\Livewire\Register\RegisterWizard;
use App\Livewire\Register\UserDetailsStep;
use Livewire\Livewire;

class LivewireComponentProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        Livewire::component('register-wizard', RegisterWizard::class);
        Livewire::component('barangay-selection-step', BarangaySelectionStep::class);
        Livewire::component('user-details-step', UserDetailsStep::class);

        Livewire::component('barangay-setup-wizard', BarangaySetupWizard::class);
        Livewire::component('barangay-information-step', BarangayInformationStep::class);
    }
}
