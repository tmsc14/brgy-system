<?php

namespace App\Livewire\Statistics;

use App\Models\Resident;
use App\Traits\StatisticTrait;
use Livewire\Component;

class ResidentsList extends Component
{
    public $statisticName = "Residents";
    public $titleIconName = "groups";

    use StatisticTrait;

    public function getRecords()
    {
        return Resident::active()->with('household');
    }

    public function getTableStructure()
    {
        return [
            'NAME' => function ($record) {
                return $record->getFullName() ?? 'N/A';
            },
            'ADDRESS' => function ($record) {
                return $record->household->street_address ?? 'N/A';
            },
        ];
    }
}
