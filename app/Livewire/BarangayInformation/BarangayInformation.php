<?php

namespace App\Livewire\BarangayInformation;

use App\Models\BarangayOfficial;
use Livewire\Component;

class BarangayInformation extends Component
{
    public function addBarangayOfficial()
    {
        $this->redirectRoute('barangay-information.barangay-official-profile');
    }

    public function editBarangayOfficial($id)
    {
        $this->redirectRoute('barangay-information.barangay-official-profile', ['id' => $id]);
    }

    public function render()
    {
        $officials = BarangayOfficial::all()->groupBy('rank')->sortKeys();

        return view('livewire.barangay-information.barangay-information', ['officials' => $officials]);
    }
}
