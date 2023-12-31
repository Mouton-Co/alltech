<?php

use App\Http\Controllers\CompanyTypeController;
use Illuminate\Support\Facades\Route;

Route::prefix('company-types')->group(function () {
    Route::get('/', [CompanyTypeController::class, 'index'])->name('company-type.index');
    Route::post('/store', [CompanyTypeController::class, 'store'])->name('company-type.store');
    Route::post('/update/{id}', [CompanyTypeController::class, 'update'])->name('company-type.update');
    Route::post('/destroy/{id}', [CompanyTypeController::class, 'destroy'])->name('company-type.destroy');
});
