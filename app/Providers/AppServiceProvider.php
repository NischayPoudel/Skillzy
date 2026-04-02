<?php

namespace App\Providers;

use App\Services\KhaltiService;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // Register Khalti Service as singleton
        $this->app->singleton(KhaltiService::class, function ($app) {
            return new KhaltiService();
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
