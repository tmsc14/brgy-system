<?php

namespace App\Livewire\SignupRequests;

use App\Models\Resident;
use App\Models\SignupRequest;
use App\Models\Staff;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Locked;
use Livewire\Component;
use Livewire\WithoutUrlPagination;
use Livewire\WithPagination;

#[Layout('layouts.app')]
class SignupRequests extends Component
{
    #[Locked]
    public $barangay_id = 0;

    use WithPagination, WithoutUrlPagination;

    public function mount()
    {
        $this->barangay_id = Auth::user()->barangay_id;
    }

    public function updateStatus($id, $status)
    {
        $isApproved = $status === SignupRequest::APPROVED_STATUS;

        $request = SignupRequest::where('barangay_id', $this->barangay_id)
            ->where('id', $id)
            ->first();

        if ($request->user_type == 'Resident')
        {
            $residentRecord = Resident::where('user_id', $request->user_id)
                ->first();

            $residentRecord->update(['is_active' => $isApproved]);
        }
        else
        {
            $staffRecord = Staff::where('user_id', $request->user_id)
                ->first();

            $staffRecord->update(['is_active' => $isApproved]);
        }

        $request->update(['status' => $status]);

        $this->dispatch('showToastr', 'success', 'Signup request ' . $status . ' successfully.');
    }

    public function render()
    {
        $requests = SignupRequest::where('barangay_id', $this->barangay_id)
            ->where('status', SignupRequest::PENDING_STATUS)
            ->paginate(10);

        return view('livewire.signup-requests.signup-requests', ['requests' => $requests]);
    }
}
