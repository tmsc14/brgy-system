<?php

namespace App\Livewire\Statistics;

use App\Models\Household;
use App\Models\Resident;
use App\Traits\StatisticTrait;
use Livewire\Component;

class HouseholdsList extends Component
{
    public $statisticName = "Households";
    public $titleIconName = "home";

    use StatisticTrait;

    public function getRecords()
    {
        return Household::with('head', 'residents');
    }

    public function getTableStructure()
    {
        return [
            'HOUSEHOLD HEAD NAME' => function ($record) {
                return $record->head_name ?? 'N/A';
            },
            'ADDRESS' => function ($record) {
                return $record->street_address ?? 'N/A';
            },
            'RESIDENTS' => function ($record) {
                return $record->number_of_residents ?? 'N/A';
            },
        ];
    }
}
