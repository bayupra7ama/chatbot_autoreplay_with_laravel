<?php

use App\Http\Controllers\ReportController;
use App\Models\Opd;
use Illuminate\Support\Facades\Route;
use App\Exports\LaporanPeriodeExport;
use Maatwebsite\Excel\Facades\Excel;

Route::get('/', function () {
    return view('chat');
});

Route::get('/chat', function () {
    return view('chat');
});

Route::post('/lapor', [ReportController::class, 'store']);

Route::get('/get-opds', function () {
    return response()->json(Opd::select('id', 'nama')->get());
});



Route::get('/export-laporan/{periode}', function ($periode) {
    $decoded = urldecode($periode);
    $laporans = session()->get('laporan_export_' . $decoded, collect());
    return Excel::download(new LaporanPeriodeExport($decoded, $laporans), 'laporan-' . $decoded . '.xlsx');
})->name('export.laporan.periode');
