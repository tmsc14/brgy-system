<?php

namespace App\Livewire\Statistics;

use App\Models\BarangayFeature;
use App\Models\Household;
use App\Models\Resident;
use Livewire\Component;

class Statistics extends Component
{
    public function mount()
    {
    }

    public function render()
    {
        $enabledStatistics = BarangayFeature::statistics()
            ->enabled()
            ->pluck('name');

        $statisticsData = [];

        if ($enabledStatistics->contains('NumberOfResidents'))
        {
            $statisticsData['1'][] = ['title' => 'NumberOfResidents', 'count' => Resident::count()];
        }

        // if ($enabledStatistics->contains('NumberOfHousehold'))
        // {
        //     $statisticsData['NumberOfHousehold'] = Household::count();
        // }

        return view('livewire.statistics.statistics', ['statisticsData' => $statisticsData]);
    }
}
