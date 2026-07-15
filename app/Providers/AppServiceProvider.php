<?php

namespace App\Providers;

use App\Support\Contracts\FileStorageServiceInterface;
use App\Support\Services\FileStorageService;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(
            FileStorageServiceInterface::class,
            FileStorageService::class,
        );
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
