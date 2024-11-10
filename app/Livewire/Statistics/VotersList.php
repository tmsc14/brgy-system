<?php

namespace App\Livewire\Statistics;

use App\Models\Resident;
use App\Traits\StatisticTrait;
use Livewire\Component;

class VotersList extends Component
{
    public $statisticName = "Registered Voters";
    public $titleIconName = "how-to-vote";

    use StatisticTrait;

    public function getRecords()
    {
        return Resident::active()->where('is_voter', true);
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
