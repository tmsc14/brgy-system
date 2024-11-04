<?php

namespace App\Livewire\Household;

use App\Models\Household;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithoutUrlPagination;
use Livewire\WithPagination;

class HouseholdList extends Component
{
    use WithPagination, WithoutUrlPagination;

    public function mount()
    {
        $user = Auth::user();

        if (!$user->staff)
        {
            $this->redirectRoute('household.view', $user->resident->household->id);
        }
    }

    public function edit($id)
    {
        $this->redirectRoute('household.view', $id);
    }

    public function delete($id)
    {
        Household::findOrFail($id)->delete();
    }

    public function add()
    {
        $this->redirectRoute('household.add');
    }

    public function render()
    {
        $households = Household::all()
            ->paginate(10);

        return view('livewire.household.household-list', compact('households'));
    }
}
