<?php

namespace App\Providers;

use App\View\Composers\AdminLayoutComposer;
use App\View\Composers\SidebarComposer;
use Illuminate\Support\Facades\View;
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
        // Registrar View Composer para o sidebar
        View::composer('components.layouts.sidebar', SidebarComposer::class);
        
        // Registrar View Composer para o admin layout
        View::composer('layouts.admin', AdminLayoutComposer::class);
    }
}
