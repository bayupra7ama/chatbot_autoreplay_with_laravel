<?php
namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class LaporanPeriodeExport implements FromView
{
    public $periode;
    public $laporans;

    public function __construct($periode, $laporans)
    {
        $this->periode = $periode;
        $this->laporans = $laporans;
    }

    public function view(): View
    {
        return view('exports.laporan-periode', [
            'periode' => $this->periode,
            'laporans' => $this->laporans,
        ]);
    }
}
