<?php

namespace App\Livewire\BarangaySetup;

use App\Traits\AppearanceSettingsTrait;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\Features\SupportFileUploads\WithFileUploads;
use Spatie\LivewireWizard\Components\StepComponent;

class AppearancesStep extends StepComponent
{
    public $theme;

    public $theme_color;
    public $primary_color;
    public $secondary_color;
    public $text_color;
    public $logo;

    use WithFileUploads, AppearanceSettingsTrait;

    public function mount()
    {
        $appearanceSettings = Auth::user()->barangay->appearanceSettings;

        $this->theme_color = $appearanceSettings->theme_color;
        $this->primary_color = $appearanceSettings->primary_color;
        $this->secondary_color = $appearanceSettings->secondary_color;
        $this->text_color = $appearanceSettings->text_color;
    }

    public function updatedTheme($value)
    {
        $themes = $this->getThemes();

        if (array_key_exists($value, $themes))
        {
            $selectedTheme = $themes[$value];
            if ($selectedTheme ?? false)
            {
                $this->theme_color = $selectedTheme['theme_color'];
                $this->primary_color = $selectedTheme['primary_color'];
                $this->secondary_color = $selectedTheme['secondary_color'];
                $this->text_color = $selectedTheme['text_color'];
            }
        }
    }

    public function updated($property)
    {
        if ($property != 'theme' && $property != 'logo_path')
        {
            $this->theme = 'custom';
        }
    }

    public function save()
    {
        if ($this->logo == '')
        {
            $this->logo = null;
        }

        $validated = $this->validate([
            'theme_color' => 'required|string',
            'primary_color' => 'required|string',
            'secondary_color' => 'required|string',
            'text_color' => 'required|string',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($validated)
        {
            $barangay = Auth::user()->barangay;

            DB::transaction(function () use ($barangay)
            {
                $barangay->update([
                    'is_setup_complete' => true
                ]);

                $barangay->appearanceSettings->update([
                    'theme_color' => $this->theme_color,
                    'primary_color' => $this->primary_color,
                    'secondary_color' => $this->secondary_color,
                    'text_color' => $this->text_color,
                    'logo_path' => isset($this->logo)
                        ? $this->logo->storePubliclyAs('logos/' . $barangay->id, 'logo.png', 'public')
                        : ''
                ]);

                $this->redirectRoute('dashboard');
            });
        }
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
