<?php

namespace App\Livewire\Statistics;

use App\Models\Resident;
use App\Traits\StatisticTrait;
use Carbon\Carbon;
use Livewire\Component;

class SeniorCitizensList extends Component
{
    public $statisticName = "Senior Citizens";
    public $titleIconName = "elderly";

    use StatisticTrait;

    public function getRecords()
    {
        $dateSixtyYearsAgo = Carbon::now()->subYears(60)->toDateString();

        return Resident::where('date_of_birth', '<=', $dateSixtyYearsAgo);
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
