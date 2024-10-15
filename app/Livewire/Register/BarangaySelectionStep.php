<?php

namespace App\Livewire\Register;

use App\Models\Barangay;
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

    public function mount(LocationService $locationService)
    {
        $this->locationService = $locationService;

        $this->selectedBarangayCode = session('selectedBarangayCode');
        $this->selectedCityCode = session('selectedCityCode');
        $this->selectedProvinceCode = session('selectedProvinceCode');
        $this->selectedRegionCode = session('selectedRegionCode');

        $this->regions = $locationService->getAllRegions();
        $this->provinces = session('provinces');
        $this->cities = session('cities');
        $this->barangays = session('barangays');
    }

    public function boot(LocationService $locationService)
    {
        $this->locationService = $locationService;
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
        $existingBarangay = Barangay::where('barangay_code', $this->selectedBarangayCode)->first();

        if ($existingBarangay)
        {
            return redirect()->route('barangay_captain.pending_turnover');
        }

        $validated = $this->validate([
            'selectedRegionCode' => 'required',
            'selectedProvinceCode' => 'required',
            'selectedCityCode' => 'required',
            'selectedBarangayCode' => 'required',
        ]);

        if ($validated)
        {
            session([
                'selectedRegionCode' => $this->selectedRegionCode,
                'selectedProvinceCode' => $this->selectedProvinceCode,
                'selectedCityCode' => $this->selectedCityCode,
                'selectedBarangayCode' => $this->selectedBarangayCode,
                'provinces' => $this->provinces,
                'cities' => $this->cities,
                'barangays' => $this->barangays
            ]);

            $this->nextStep();
        }
    }

    public function stepInfo(): array
    {
        return [
            'label' => 'Select Barangay',
            'order' => '1'
        ];
    }

    public function render()
    {
        return view('livewire.register.barangay-selection-step');
    }
}
