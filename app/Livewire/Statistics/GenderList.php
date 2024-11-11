<?php

namespace App\Livewire\Statistics;

use App\Models\Resident;
use App\Traits\StatisticTrait;
use Livewire\Component;

class GenderList extends Component
{
    public $statisticName = "Gender";
    public $titleIconName = "wc";

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
            'GENDER' => function ($record) {
                return $record->gender ?? 'N/A';
            },
        ];
    }
}
