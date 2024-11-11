<?php

namespace App\Livewire\Statistics;

use App\Models\Resident;
use App\Traits\StatisticTrait;
use Carbon\Carbon;
use Livewire\Component;

class AgeList extends Component
{
    public $statisticName = "Age Groups";
    public $titleIconName = "groups";

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
            'AGE' => function ($record) {
                return Carbon::parse($record->date_of_birth)->age ?? 'N/A';
            },
        ];
    }
}
