<?php

namespace App\Livewire\Dashboard;

use App\Models\Household;
use App\Models\Resident;
use App\Models\SignupRequest;
use App\Services\LocationService;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.app')]
class BarangayCaptainDashboard extends Component
{
    public $cityName;
    public $provinceName;
    public $householdCount;

    public $demoRequesterName;
    public $demoRequesterRole;

    public $totalResidentsCount;

    public function mount(LocationService $locationService)
    {
        $barangay = Auth::user()->barangay;

        $this->householdCount = Household::where('barangay_id', $barangay->id)->count();
        $this->cityName = $locationService->getCityByCitymunCode($barangay->city_code)['citymunDesc']; 
        $this->provinceName = $locationService->getProvinceByProvCode($barangay->province_code)['provDesc']; 
        
        $demoRequest = SignupRequest::where('barangay_id', $barangay->id)
            ->where('status', 'pending')
            ->first();

        if ($demoRequest)
        {
            $this->demoRequesterName = $demoRequest->first_name . ' ' . $demoRequest->last_name;
            $this->demoRequesterRole = $demoRequest->user_type;
        }

        $this->totalResidentsCount = Resident::where('barangay_id', $barangay->id)
            ->count();
    }

    public function goToRequests()
    {
        $this->redirectRoute('requests');
    }

    public function render()
    {
        return view('livewire.dashboard.barangay-captain-dashboard');
    }
}