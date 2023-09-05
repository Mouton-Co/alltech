<?php

use App\Http\Controllers\CompanyController;
use Illuminate\Support\Facades\Route;

Route::prefix('companies')->group(function () {
    Route::get('/', [CompanyController::class, 'index'])->name('company.index');
    Route::get('/create', [CompanyController::class, 'create'])->name('company.create');
    Route::post('/store', [CompanyController::class, 'store'])->name('company.store');
    Route::get('/edit/{id}', [CompanyController::class, 'edit'])->name('company.edit');
    Route::post('/update/{id}', [CompanyController::class, 'update'])->name('company.update');
    Route::post('/destroy/{id}', [CompanyController::class, 'destroy'])->name('company.destroy');
});
