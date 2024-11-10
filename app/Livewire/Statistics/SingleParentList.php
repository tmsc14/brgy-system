<?php

namespace App\Livewire\Statistics;

use App\Models\Resident;
use App\Traits\StatisticTrait;
use Carbon\Carbon;
use Livewire\Component;

class SingleParentList extends Component
{
    public $statisticName = "Single Parents";
    public $titleIconName = "escalator-warning";

    use StatisticTrait;

    public function getRecords()
    {
        return Resident::active()->with('household')->where('is_single_parent', true);
    }

    public function getTableStructure()
    {
        return [
            'NAME' => function ($record) {
                return $record->getFullName() ?? 'N/A';
            },
            'ADDRESS' => function ($record) {
                error_log($record->household);
                return $record->household ? $record->household->street_address : 'N/A';
            },
            'AGE' => function ($record) {
                return Carbon::parse($record->date_of_birth)->age ?? 'N/A';
            },
        ];
    }
}
