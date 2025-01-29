<?php

use Illuminate\Support\Facades\Route;

Route::resource('calendar', \App\Http\Controllers\CalendarController::class)->only(['index']);
Route::get('calendar/export', [\App\Http\Controllers\CalendarController::class, 'export'])->name('calendar.export');
