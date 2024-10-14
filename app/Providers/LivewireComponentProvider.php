<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Livewire\Register\RegisterWizard;

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
    }
}
