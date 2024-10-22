<?php

namespace App\Livewire\SignupRequests;

use App\Models\SignupRequest;
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

    public function approve($id)
    {
        
    }

    public function deny($id)
    {
        
    }

    public function render()
    {
        $requests = SignupRequest::where('barangay_id', $this->barangay_id)
            ->paginate(1);

        return view('livewire.signup-requests.signup-requests', ['requests' => $requests]);
    }
}
