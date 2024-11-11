<?php

namespace App\Livewire\Settings;

use App\Models\Staff;
use Livewire\Attributes\Locked;
use Livewire\Attributes\Validate;
use Livewire\Component;

class StaffSettings extends Component
{
    #[Validate('required|string')]
    public $first_name;

    #[Validate('nullable|string')]
    public $middle_name;

    #[Validate('required|string')]
    public $last_name;

    #[Validate('required|date')]
    public $date_of_birth;

    public Staff $staffRecord;

    public function mount()
    {
        $this->staffRecord = Staff::find(auth()->user()->id);

        $this->first_name = $this->staffRecord->first_name;
        $this->middle_name = $this->staffRecord->middle_name;
        $this->last_name = $this->staffRecord->last_name;
        $this->date_of_birth = $this->staffRecord->date_of_birth;
    }

    public function save()
    {
        $this->validate();

        $this->staffRecord->update($this->all());

        toastr()->success('Profile updated.');
    }

    public function render()
    {
        return view('livewire.settings.staff-settings');
    }
}
