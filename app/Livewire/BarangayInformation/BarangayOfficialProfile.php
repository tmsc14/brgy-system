<?php

namespace App\Livewire\BarangayInformation;

use App\Models\BarangayOfficial;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Locked;
use Livewire\Component;
use Livewire\Features\SupportFileUploads\WithFileUploads;

class BarangayOfficialProfile extends Component
{
    #[Locked]
    public $barangayOfficial;

    public $name;
    public $contact_number;
    public $title;
    public $rank;
    public $photo;

    use WithFileUploads;

    public function mount($id = null)
    {
        if ($id)
        {
            $this->barangayOfficial = BarangayOfficial::findOrFail($id);

            $this->name = $this->barangayOfficial->name;
            $this->contact_number = $this->barangayOfficial->contact_number;
            $this->title = $this->barangayOfficial->title;
            $this->rank = $this->barangayOfficial->rank;
            $this->photo = $this->barangayOfficial->picture;
        }
    }

    public function cancel()
    {
        $this->redirectRoute('barangay-information');
    }

    public function delete()
    {
        $this->barangayOfficial->delete();
        $this->redirectRoute('barangay-information');
    }

    public function save()
    {
        $data = $this->validate([
            'name' => 'required|string|max:255',
            'contact_number' => 'required|string',
            'title' => 'required|string',
            'rank' => 'required|string',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $data['photo'] = $this->photo->storePublicly('officials/' . Auth::user()->barangay->id, 'public');

        if ($this->barangayOfficial && $this->barangayOfficial->id)
        {
            $this->barangayOfficial->update($data);
        }
        else
        {
            $data['barangay_id'] = Auth::user()->barangay->id;
            error_log(json_encode($data));
            BarangayOfficial::create($data);
        }

        $this->redirectRoute('barangay-information');
    }

    public function render()
    {
        return view('livewire.barangay-information.barangay-official-profile');
    }
}
