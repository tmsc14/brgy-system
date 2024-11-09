<?php

namespace App\Traits;

use App\Services\LocationService;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Livewire\WithoutUrlPagination;
use Livewire\WithPagination;

trait StatisticTrait
{
    private LocationService $locationService;
    
    use WithPagination, WithoutUrlPagination;

    public function boot(LocationService $locationService)
    {
        $this->locationService = $locationService;
    }

    public function back()
    {
        $this->redirectRoute('dashboard');
    }

    public function generateReport()
    {
        $records = $this->getRecords()->get();
        $tableStructure = $this->getTableStructure();

        $barangayData = $this->getBarangayDataForDocument();

        $pdfData = array_merge(
            $barangayData,
            ['records' => $records, 'tableStructure' => $tableStructure]
        );

        $pdf = Pdf::loadView('components.statistics.report-template', $pdfData);

        return response()->streamDownload(function () use ($pdf) {
            echo $pdf->setPaper('a4')->stream();
        }, 'report.pdf');
    }

    private function getBarangayDataForDocument()
    {
        $barangay = auth()->user()->barangay;

        $province = $this->locationService->getProvinceByProvCode($barangay->province_code)['provDesc'];
        $city = $this->locationService->getCityByCitymunCode($barangay->city_code)['citymunDesc'];
        $barangayName = $barangay->name;
        $dateGenerated = Carbon::now();
        $barangayLogo = $barangay->appearance_settings->logo_path
            ? base_path('public/storage/' . $barangay->appearance_settings->logo_path)
            : base_path('public/resources/img/default-logo.png');
        $statisticName = $this->statisticName;
        $titleIconName = $this->titleIconName;

        return compact('province', 'city', 'barangayName', 'dateGenerated', 'barangayLogo', 'statisticName', 'titleIconName');
    }

    public function render()
    {
        $records = $this->getRecords()->paginate(10);
        $tableStructure = $this->getTableStructure();

        return view('components.statistics.statistic-list-template', compact('records', 'tableStructure'));
    }
}
