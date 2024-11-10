<?php

namespace App\Livewire;


use App\Models\Household;
use App\Models\Resident;
use App\Models\SignupRequest;
use App\Services\LocationService;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Component;


class BrgyBanner extends Component
{
    public $cityName;
    public $provinceName;
    public $householdCount;

    public function mount(LocationService $locationService)
    {
        $barangay = Auth::user()->barangay;

        $this->householdCount = Household::hasActiveResidents()->count();
        $this->cityName = $locationService->getCityByCitymunCode($barangay->city_code)['citymunDesc']; 
        $this->provinceName = $locationService->getProvinceByProvCode($barangay->province_code)['provDesc'];
    }

    public function render()
    {
        return view('livewire.brgy-banner');
    }
}
