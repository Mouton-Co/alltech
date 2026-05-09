<?php

use App\Http\Controllers\ContactController;
use App\Livewire\Contact\Pages\Index;
use App\Livewire\Contact\Pages\Merge;
use Illuminate\Support\Facades\Route;

Route::prefix('contacts')->group(function () {
    Route::get('/export', [ContactController::class, 'export'])->name('contacts.export');
    Route::livewire('/merge/{targetContactId}', Merge::class)->name('contact.merge');
    Route::livewire('/', Index::class)->name('contact.index');
});
