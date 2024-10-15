<?php

namespace App\Livewire\BarangaySetup;

use App\Traits\AppearanceSettingsTrait;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\Features\SupportFileUploads\WithFileUploads;
use Spatie\LivewireWizard\Components\StepComponent;

class AppearancesStep extends StepComponent
{
    public $theme_color;
    public $primary_color;
    public $secondary_color;
    public $text_color;
    public $logo_path;

    use WithFileUploads, AppearanceSettingsTrait;

    public function mount()
    {
        $appearanceSettings = Auth::user()->barangay->appearanceSettings;

        $this->theme_color = $appearanceSettings->theme_color;
        $this->primary_color = $appearanceSettings->primary_color;
        $this->secondary_color = $appearanceSettings->secondary_color;
        $this->text_color = $appearanceSettings->text_color;
        $this->logo_path = $appearanceSettings->logo_path;
    }

    public function save()
    {
        error_log($this->theme_color);
    }

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
}
