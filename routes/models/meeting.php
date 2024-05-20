<?php

use App\Http\Controllers\MeetingController;
use Illuminate\Support\Facades\Route;

Route::prefix('meetings')->group(function () {
    Route::get('/', [MeetingController::class, 'index'])->name('meeting.index');
    Route::get('/create', [MeetingController::class, 'create'])->name('meeting.create');
    Route::post('/store', [MeetingController::class, 'store'])->name('meeting.store');
    Route::get('/edit/{id}', [MeetingController::class, 'edit'])->name('meeting.edit');
    Route::post('/update/{id}', [MeetingController::class, 'update'])->name('meeting.update');
    Route::post('/destroy/{id}', [MeetingController::class, 'destroy'])->name('meeting.destroy');
    Route::post('/cancel/{id}', [MeetingController::class, 'cancel'])->name('meeting.cancel');
});
