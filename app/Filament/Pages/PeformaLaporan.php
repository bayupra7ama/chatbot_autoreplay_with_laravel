<?php

namespace App\Filament\Pages;

use App\Models\Report;
use Filament\Pages\Page;

class PeformaLaporan extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-chart-bar';
    protected static ?string $title = 'Performa Laporan';
    protected static string $view = 'filament.pages.peforma-laporan';

    public string $filterBy = 'month';
    public ?string $startDate = null;
    public ?string $endDate = null;

    // ✅ ubah jadi protected agar tidak diproses sebagai model
    protected $groupedReports;

    public function mount(): void
    {
        $this->groupedReports = collect();
        $this->loadData();
    }

    public function updated($property): void
    {
        $this->loadData();
    }

    public function applyFilter()
    {
        $this->loadData();
    }

    public function loadData()
    {
        if ($this->filterBy === 'month') {
            $this->groupedReports = Report::orderBy('created_at', 'desc')
                ->get()
                ->groupBy(fn($item) => \Carbon\Carbon::parse($item->created_at)->format('F Y'));
        } elseif ($this->filterBy === 'week') {
            $this->groupedReports = Report::orderBy('created_at', 'desc')
                ->get()
                ->groupBy(fn($item) => 'Minggu ke-' . \Carbon\Carbon::parse($item->created_at)->format('W Y'));
        } elseif ($this->filterBy === 'year') { // ✅ Tambahkan ini
            $this->groupedReports = Report::orderBy('created_at', 'desc')
                ->get()
                ->groupBy(fn($item) => \Carbon\Carbon::parse($item->created_at)->format('Y'));
        } elseif ($this->filterBy === 'range' && $this->startDate && $this->endDate) {
            $this->groupedReports = Report::whereBetween('created_at', [$this->startDate, $this->endDate])
                ->orderBy('created_at', 'asc')
                ->get()
                ->groupBy(fn($item) => \Carbon\Carbon::parse($item->created_at)->format('d M Y'));
        } else {

            $this->groupedReports = collect();
        }

        // ⬇ Tambahkan ini setelah semua pengelompokan data
        foreach ($this->groupedReports as $periode => $laporans) {
            session()->put('laporan_export_' . $periode, $laporans);
        }
    }


    protected function getViewData(): array
    {
        return [
            'groupedReports' => $this->groupedReports,
        ];
    }
}
