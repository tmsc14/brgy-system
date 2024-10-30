<?php

namespace App\Livewire\BarangaySetup;

use App\Classes\RGBColor;
use App\Helpers\ThemeHelper as ThemeHelper;
use Livewire\Component;
use App\Traits\AppearanceSettingsTrait;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Features\SupportFileUploads\WithFileUploads;

class AppearanceSettings extends Component
{
    public $theme;

    public $theme_color;
    public $primary_color;
    public $secondary_color;
    public $logo;

    public $is_wizard_step;

    use WithFileUploads, AppearanceSettingsTrait;

    public function mount($is_wizard_step = false)
    {
        $appearanceSettings = Auth::user()->barangay->appearance_settings;

        $this->theme_color = RGBColor::fromString($appearanceSettings->theme_color)->toHex();
        $this->primary_color = RGBColor::fromString($appearanceSettings->primary_color)->toHex();
        $this->secondary_color = RGBColor::fromString($appearanceSettings->secondary_color)->toHex();

        $this->is_wizard_step = $is_wizard_step;
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

                $barangay->appearance_settings->update([
                    'theme_color' => $this->convertHexToRGB($this->theme_color),
                    'primary_color' => $this->convertHexToRGB($this->primary_color),
                    'secondary_color' => $this->convertHexToRGB($this->secondary_color),
                    'logo_path' => isset($this->logo)
                        ? $this->logo->storePubliclyAs('logos/' . $barangay->id, 'logo.png', 'public')
                        : ''
                ]);
            });

            $appearanceSettings = $barangay->appearance_settings;

            ThemeHelper::setSessionAppearanceSettings($appearanceSettings);

            $this->redirectRoute('dashboard');
        }
    }

    public function render()
    {
        return view('livewire.barangay-setup.appearance-settings');
    }
}
