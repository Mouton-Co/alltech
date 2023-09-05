<?php

use App\Http\Controllers\ContactController;
use Illuminate\Support\Facades\Route;

Route::prefix('contacts')->group(function () {
    Route::get('/', [ContactController::class, 'index'])->name('contact.index');
    Route::get('/create', [ContactController::class, 'create'])->name('contact.create');
    Route::post('/store', [ContactController::class, 'store'])->name('contact.store');
    Route::get('/edit/{id}', [ContactController::class, 'edit'])->name('contact.edit');
    Route::post('/update/{id}', [ContactController::class, 'update'])->name('contact.update');
    Route::post('/destroy/{id}', [ContactController::class, 'destroy'])->name('contact.destroy');
});
