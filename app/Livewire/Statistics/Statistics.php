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
        
        $residentsThisYear = $this->getResidentCountLastFiveDays(false, $labels);
        $residentsLastYear = $this->getResidentCountLastFiveDays(true, $labels);

        error_log(json_encode(array_values($labels)));  

        return [
            'title' => 'Barangay Residents',
            'labels' => array_values($labels),
            'residentsThisYear' => $residentsThisYear,
            'residentsLastYear' => $residentsLastYear
        ];
    }

    private function getResidentCountLastFiveDays($lastYear, $labels)
    {
        $dateSpanStart = Carbon::now()->subDays(5)->startOfDay();
        $dateSpanEnd = Carbon::now()->endOfDay();

        if ($lastYear)
        {
            $dateSpanStart = $dateSpanStart->subYear();
            $dateSpanEnd = $dateSpanEnd->subYear();
        }

        $counts = Resident::whereBetween('created_at', [
            $dateSpanStart,
            $dateSpanEnd
        ])
            ->get()
            ->groupBy(function ($date)
            {
                return Carbon::parse($date->created_at)->format('m-d'); // Format to match labels
            })
            ->map(fn($day) => $day->count())
            ->toArray();

        // Ensure counts are in the order of the last 5 days with zeros for days with no records
        $values = array_values(array_map(fn($label) => $counts[$label] ?? 0, $labels));

        return [
            'label' => $dateSpanStart->year,
            'data' => $values,
            'stack' => $lastYear ? 'A' : 'B'
        ];
    }
}
