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
    public function residentsList()
    {
        $this->redirectRoute('statistics.residents.list');
    }

    public function pwdList()
    {
        $this->redirectRoute('statistics.pwd');
    }

    public function households()
    {
        $this->redirectRoute('statistics.households');
    }

    public function voters()
    {
        $this->redirectRoute('statistics.voters');
    }

    public function seniors()
    {
        $this->redirectRoute('statistics.seniors');
    }

    public function singleparents()
    {
        $this->redirectRoute('statistics.single-parents');
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

        if ($enabledStatistics->contains('Gender'))
        {
            $statisticsData['Gender'] = ['maleCount' => Resident::gender('Male')->count(), 'femaleCount' => Resident::gender('Female')->count()];
        }

        if ($enabledStatistics->contains('Employment'))
        {
            $statisticsData['Employment'] = ['employedCount' => Resident::employed(true)->count(), 'unemployedCount' => Resident::employed(false)->count()];
        }

        if ($enabledStatistics->contains('Employment'))
        {
            $statisticsData['Employment'] = ['employedCount' => Resident::employed(true)->count(), 'unemployedCount' => Resident::employed(false)->count()];
        }

        if ($enabledStatistics->contains('AgeDemographic'))
        {
            $now = Carbon::now();

            $statisticsData['AgeDemographic'] = [
                '0-17' => Resident::whereBetween('date_of_birth', [
                    Carbon::now()->subYears(17)->toDateString(),
                    $now,
                ])->count(),

                '18-30' => Resident::whereBetween('date_of_birth', [
                    Carbon::now()->subYears(30)->toDateString(),
                    Carbon::now()->subYears(18)->toDateString(),
                ])->count(),

                '31-59' => Resident::whereBetween('date_of_birth', [
                    Carbon::now()->subYears(59)->toDateString(),
                    Carbon::now()->subYears(31)->toDateString(),
                ])->count(),

                '60+' => Resident::where('date_of_birth', '<=', Carbon::now()->subYears(60)->toDateString())->count(),
            ];
        }

        if ($enabledStatistics->contains('NumberOfPWD'))
        {
            $statisticsData['NumberOfPWD'] = ['title' => 'No. of PWDs', 'count' => Resident::pwd(true)->count()];
        }

        if ($enabledStatistics->contains('NumberOfSingleParents'))
        {
            $statisticsData['NumberOfSingleParents'] = ['title' => 'No. of Solo Parents', 'count' => Resident::where('is_single_parent', true)->count()];
        }

        if ($enabledStatistics->contains('NumberOfVoters'))
        {
            $statisticsData['NumberOfVoters'] = ['title' => 'No. of Voters', 'count' => Resident::voter(true)->count()];
        }

        if ($enabledStatistics->contains('AgeDemographic'))
        {
            $statisticsData['Seniors'] = ['title' => 'No. of Senior Citizens', 'count' => Resident::where('date_of_birth', '<=', Carbon::now()->subYears(60)->toDateString())->count()];
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

        $counts = Resident::active()
            ->whereBetween('created_at', [
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
        $values = array_values(array_map(fn($label) => $counts[$label] ?? 0, array_keys($labels)));

        return [
            'label' => $dateSpanStart->year,
            'data' => $values,
            'stack' => $lastYear ? 'A' : 'B'
        ];
    }
}
