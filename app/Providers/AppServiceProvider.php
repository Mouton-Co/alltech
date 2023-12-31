<?php

namespace App\Providers;

use App\View\Components\AppLayout;
use App\View\Components\DashboardLayout;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Blade::component('app', AppLayout::class);
        Blade::component('dashboard', DashboardLayout::class);
        Paginator::defaultView('components.table.pagination');
    }
}
