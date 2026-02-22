<?php

use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/', function () {
        return redirect()->route('meeting.index');
    })->name('dashboard');
    Route::post('/toggle-dark-mode', [UserController::class, 'toggleDarkMode'])->name('toggle-dark-mode');
    Route::livewire('/analytics', \App\Livewire\Analytics\Pages\Index::class)->name('analytics.index');

    require 'models/user.php';
    require 'models/company-type.php';
    require 'models/company.php';
    require 'models/contact.php';
    require 'models/meeting.php';
    require 'models/reporting.php';
    require 'models/email-cron.php';
    require 'models/calendar.php';
});

require 'auth.php';
