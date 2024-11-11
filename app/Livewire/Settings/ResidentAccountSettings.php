<?php

namespace App\Livewire\Settings;

use App\Traits\UserSettingsTrait;
use Livewire\Component;

class ResidentAccountSettings extends Component
{
    use UserSettingsTrait;

    public function render()
    {
        return view('livewire.settings.resident-account-settings');
    }
}
