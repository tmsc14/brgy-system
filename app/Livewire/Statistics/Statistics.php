<?php

namespace App\Livewire\Statistics;

use App\Helpers\DateTimeHelper;
use App\Models\BarangayFeature;
use App\Models\Household;
use App\Models\Resident;
use Carbon\Carbon;
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

        $statisticsData['ResidentsBarGraph'] = $this->getResidentBarGraphData();

        error_log(json_encode($statisticsData));

        if ($enabledStatistics->contains('NumberOfResidents'))
        {
            $statisticsData['NumberOfResidents'] = ['title' => 'No. of Residents', 'count' => Resident::count()];
        }

        if ($enabledStatistics->contains('NumberOfHousehold'))
        {
            $statisticsData['NumberOfHousehold'] = ['title' => 'No. of Households', 'count' => Household::count()];
        }

        return view('livewire.statistics.statistics', ['statisticsData' => $statisticsData]);
    }

    private function getResidentBarGraphData()
    {
        $labels = DateTimeHelper::getLastFiveDays();

        $dateSpanStart = Carbon::now()->subDays(5)->startOfDay();
        $dateSpanEnd = Carbon::now()->subDays(5)->startOfDay();

        $counts = Resident::whereBetween('created_at', [
            Carbon::now()->subDays(5)->startOfDay(),
            Carbon::now()->endOfDay()
        ])
            ->get()
            ->groupBy(function ($date)
            {
                return Carbon::parse($date->created_at)->format('j D'); // Format to match labels
            })
            ->map(fn($day) => $day->count())
            ->toArray();

        // Ensure counts are in the order of the last 5 days with zeros for days with no records
        $values = array_map(fn($label) => $counts[$label] ?? 0, $labels);

        return [
            'title' => 'No. of Residents',
            'labels' => $labels,
            'values' => $values
        ];
    }
}
