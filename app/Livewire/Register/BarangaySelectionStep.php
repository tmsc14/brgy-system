<?php

namespace App\Livewire\Register;

use App\Services\LocationService;
use Spatie\LivewireWizard\Components\StepComponent;

class BarangaySelectionStep extends StepComponent
{
    protected LocationService $locationService;

    public $regions = [];
    public $provinces = [];
    public $cities = [];
    public $barangays = [];

    public $selectedRegionCode = '';
    public $selectedProvinceCode = '';
    public $selectedCityCode = '';
    public $selectedBarangayCode = '';

    public function boot(LocationService $locationService)
    {
        $this->locationService = $locationService;

        $this->regions = $locationService->getAllRegions();
    }

    public function updatedSelectedRegionCode($value)
    {
        $this->provinces = $this->locationService->getProvincesByRegCode($value);

        $this->reset('selectedProvinceCode', 'selectedCityCode', 'selectedBarangayCode');
    }

    public function updatedSelectedProvinceCode($value)
    {
        $this->cities = $this->locationService->getCitiesByProvCode($value);

        $this->reset('selectedCityCode', 'selectedBarangayCode');
    }

    public function updatedSelectedCityCode($value)
    {
        $this->barangays = $this->locationService->getBarangaysByCitymunCode($value);

        $this->reset('selectedBarangayCode');
    }

    public function goToNextStep()
    {
        $validated = $this->validate([
            'selectedRegionCode' => 'required',
            'selectedProvinceCode' => 'required',
            'selectedCityCode' => 'required',
            'selectedBarangayCode' => 'required',
        ]);

        if ($validated)
        {
            $this->nextStep();
        }
    }

    public function render()
    {
        return view('livewire.register.barangay-selection-step');
    }
}
