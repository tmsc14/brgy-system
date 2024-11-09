<?php

namespace App\Livewire\Statistics;

use App\Models\Resident;
use App\Traits\StatisticTrait;
use Livewire\Component;

class PwdList extends Component
{
    public $statisticName = "PWDs";
    public $titleIconName = "accessible";

    use StatisticTrait;

    public function getRecords()
    {
        return Resident::where('is_pwd', true);
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
