<?php

namespace App\Livewire\Statistics;

use App\Models\Resident;
use App\Traits\StatisticTrait;
use Livewire\Component;

class EmploymentList extends Component
{
    public $statisticName = "Employment";
    public $titleIconName = "badge";

    use StatisticTrait;

    public function getRecords()
    {
        return Resident::active();
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
            'EMPLOYMENT STATUS' => function ($record) {
                return $record->is_employed ? 'Employed' : 'Unemployed';
            },
        ];
    }
}
