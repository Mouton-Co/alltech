<?php

use App\Http\Controllers\ReportingController;
use Illuminate\Support\Facades\Route;

Route::prefix('reporting')->group(function () {
    Route::get('/', [ReportingController::class, 'index'])->name('reporting.index');
});
