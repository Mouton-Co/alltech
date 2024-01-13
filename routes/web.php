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
    Route::get('/', function () { return view('layouts.dashboard'); })->name('dashboard');
    Route::post('/toggle-dark-mode', [UserController::class, 'toggleDarkMode'])->name('toggle-dark-mode');

    require_once 'models/user.php';
    require_once 'models/company-type.php';
    require_once 'models/company.php';
    require_once 'models/contact.php';
    require_once 'models/meeting.php';
    require_once 'models/reporting.php';
});

require_once 'auth.php';
