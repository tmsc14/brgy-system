<?php

namespace App\Livewire\BarangaySetup;

use App\Models\BarangayFeature;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Computed;
use Livewire\Component;

class FeaturesSettings extends Component
{
    public $selectedFeatures = []; // Holds the checked feature IDs

    public $is_wizard_step;

    public function mount($is_wizard_step = false)
    {
        $this->is_wizard_step = $is_wizard_step;

        $this->loadFeatures();
    }

    #[Computed]
    public function featuresByCategory()
    {
        return BarangayFeature::where('barangay_id', Auth::user()->barangay_id)
            ->get(['id', 'category', 'name', 'is_enabled'])
            ->groupBy('category');
    }

    public function loadFeatures()
    {
        $this->selectedFeatures = BarangayFeature::where('barangay_id', Auth::user()->barangay_id)
            ->where('is_enabled', true)
            ->pluck('id')
            ->toArray();
    }

    public function save()
    {
        // Enable features based on the selected checkboxes
        BarangayFeature::where('barangay_id', Auth::user()->barangay_id)
            ->update(['is_enabled' => false]); // Disable all first

        // Enable only the selected features
        BarangayFeature::whereIn('id', $this->selectedFeatures)
            ->update(['is_enabled' => true]);

        session()->flash('message', 'Features updated successfully.');
    }

    public function render()
    {
        return view('livewire.barangay-setup.features-settings');
    }
}
