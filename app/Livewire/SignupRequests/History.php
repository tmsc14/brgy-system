<?php

namespace App\Livewire\SignupRequests;

use App\Models\SignupRequest;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\Features\SupportPagination\WithoutUrlPagination;
use Livewire\WithPagination;

#[Layout('layouts.app')]
class History extends Component
{
    #[Locked]
    public $barangay_id = 0;

    use WithPagination, WithoutUrlPagination;

    public function mount()
    {
        $this->barangay_id = Auth::user()->barangay_id;
    }

    public function render()
    {
        $requests = SignupRequest::where('barangay_id', $this->barangay_id)
            ->whereNot('status', SignupRequest::PENDING_STATUS)
            ->paginate(10);

        return view('livewire.signup-requests.history', ['requests' => $requests]);
    }
}
