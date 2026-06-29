<?php

namespace Modules\Core\Providers;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;

class CoreServiceProvider extends ServiceProvider
{
    /**
     * Register module services.
     */
    public function register(): void
    {
        $this->mergeConfigFrom(
            __DIR__.'/../Config/core.php',
            'core'
        );
    }

    /**
     * Bootstrap module services.
     */
    public function boot(): void
    {
        // Load migrations
        $this->loadMigrationsFrom(
            __DIR__.'/../Database/Migrations'
        );

        // Load routes
        if (file_exists(__DIR__.'/../Routes/api.php')) {
            Route::middleware('api')
                ->group(__DIR__.'/../Routes/api.php');
        }

        if (file_exists(__DIR__.'/../Routes/web.php')) {
            Route::middleware('web')
                ->group(__DIR__.'/../Routes/web.php');
        }

    }
}
