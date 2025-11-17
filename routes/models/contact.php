<?php

use App\Http\Controllers\ContactController;
use Illuminate\Support\Facades\Route;

Route::prefix('contacts')->group(function () {
    Route::get('/', [ContactController::class, 'index'])->name('contact.index');
    Route::post('/store', [ContactController::class, 'store'])->name('contact.store');
    Route::post('/update/{id}', [ContactController::class, 'update'])->name('contact.update');
    Route::post('/destroy/{id}', [ContactController::class, 'destroy'])->name('contact.destroy');
    Route::get('/export', [ContactController::class, 'export'])->name('contacts.export');
});
