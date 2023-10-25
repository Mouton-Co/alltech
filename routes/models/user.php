<?php

use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::prefix('users')->group(function () {
    Route::get('/', [UserController::class, 'index'])->name('user.index');
    Route::post('/store', [UserController::class, 'store'])->name('user.store');
    Route::post('/update/{id}', [UserController::class, 'update'])->name('user.update');
    Route::post('/destroy/{id}', [UserController::class, 'destroy'])->name('user.destroy');
});
