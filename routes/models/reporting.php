<?php

use App\Http\Controllers\ReportingController;
use Illuminate\Support\Facades\Route;

Route::prefix('reporting')->group(function () {
    Route::get('/', [ReportingController::class, 'report'])->name('reporting.report');
    Route::get('/index', [ReportingController::class, 'index'])->name('reporting.index');
    Route::post('/store', [ReportingController::class, 'store'])->name('reporting.store');
    Route::post('/update', [ReportingController::class, 'update'])->name('reporting.update');
    Route::post('/destroy/{id}', [ReportingController::class, 'destroy'])->name('reporting.destroy');
    Route::post('/export', [ReportingController::class, 'export'])->name('reporting.export');
});
