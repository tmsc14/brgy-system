<?php

namespace App\Livewire\Household;

use App\Models\Resident;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.app')]
class Household extends Component
{
    public $residentsList;

    public function boot()
    {
        $user = Auth::user();

        if ($user && $user->resident && $user->resident->household)
        {
            $this->residentsList = $user->resident->household->residents;
        }
        else
        {
            $this->residentsList = collect();
        }
    }

    public function edit($id)
    {
        $this->redirectRoute('household.edit-resident', ['id' => $id]);
    }

    public function delete($id)
    {
        $user = Auth::user();
        $resident = Resident::findOrFail($id);

        if (!isset($resident->user_id))
        {
            $resident->delete();
        }
        else
        {
            $this->addError('resident', 'Cannot delete the record of the head of the household.');
        }
    }

    public function addResident()
    {
        $this->redirectRoute('household.add-resident');
    }

    public function render()
    {
        return view('livewire.household.household');
    }
}
