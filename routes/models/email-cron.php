<?php

use Illuminate\Support\Facades\Route;

Route::resource('email-cron', \App\Http\Controllers\EmailCronController::class);
