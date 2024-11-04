<?php

namespace App\Livewire\Household;

use App\Models\Household as ModelsHousehold;
use App\Models\Resident;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Locked;
use Livewire\Component;


class Household extends Component
{
    #[Locked]
    public $householdId;

    public function mount($id)
    {
        $this->householdId = $id;
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
        $this->redirectRoute('household.add-resident', ['householdId' => $this->householdId]);
    }

    public function render()
    {
        $residentsList = ModelsHousehold::findOrFail($this->householdId)->residents->paginate(10);

        return view('livewire.household.household', compact('residentsList'));
    }
}
