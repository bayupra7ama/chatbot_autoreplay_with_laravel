<?php

namespace App\Http\Controllers;

use App\Models\Report;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required',
            'opd' => 'required',
            'masalah' => 'required',
            'deskripsi' => 'required',
            'kontak' => 'required',
        ]);

        Report::create($validated);

        
        return response()->json(['message' => 'Laporan berhasil dikirim. Terima kasih!']);
    }
}
