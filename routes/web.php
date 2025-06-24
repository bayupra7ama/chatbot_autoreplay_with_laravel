<?php

use App\Http\Controllers\ReportController;
use App\Models\Opd;
use Illuminate\Support\Facades\Route;

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

