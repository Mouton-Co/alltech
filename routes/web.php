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
    Route::get('/', function () { return view('auth.home'); })->name('dashboard');
    Route::post('/toggle-dark-mode', [UserController::class, 'toggleDarkMode'])->name('toggle-dark-mode');

    require_once 'models/user.php';
});

require_once 'auth.php';
