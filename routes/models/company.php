<?php

use App\Http\Controllers\CompanyController;
use Illuminate\Support\Facades\Route;

Route::prefix('companies')->group(function () {
    Route::get('/', [CompanyController::class, 'index'])->name('company.index');
    Route::post('/store', [CompanyController::class, 'store'])->name('company.store');
    Route::post('/update/{id}', [CompanyController::class, 'update'])->name('company.update');
    Route::post('/destroy/{id}', [CompanyController::class, 'destroy'])->name('company.destroy');
});
