<?php

declare(strict_types=1);

namespace Modules\OBD\Providers;

use Illuminate\Support\ServiceProvider;
use Modules\OBD\Contracts\Repositories\ObdDeviceRepositoryInterface;
use Modules\OBD\Contracts\Repositories\ObdSessionRepositoryInterface;
use Modules\OBD\Contracts\Repositories\VehicleObdDeviceRepositoryInterface;
use Modules\OBD\Contracts\Services\ObdDeviceServiceInterface;
use Modules\OBD\Contracts\Services\ObdSessionServiceInterface;
use Modules\OBD\Contracts\Services\VehicleObdDeviceServiceInterface;
use Modules\OBD\Repositories\ObdDeviceRepository;
use Modules\OBD\Repositories\ObdSessionRepository;
use Modules\OBD\Repositories\VehicleObdDeviceRepository;
use Modules\OBD\Services\ObdDeviceService;
use Modules\OBD\Services\ObdSessionService;
use Modules\OBD\Services\VehicleObdDeviceService;

final class OBDServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->singleton(
            ObdDeviceRepositoryInterface::class,
            ObdDeviceRepository::class,
        );

        $this->app->singleton(
            ObdDeviceServiceInterface::class,
            ObdDeviceService::class,
        );

        $this->app->singleton(
            VehicleObdDeviceRepositoryInterface::class,
            VehicleObdDeviceRepository::class,
        );

        $this->app->singleton(
            VehicleObdDeviceServiceInterface::class,
            VehicleObdDeviceService::class,
        );

        $this->app->singleton(
            ObdSessionRepositoryInterface::class,
            ObdSessionRepository::class,
        );

        $this->app->singleton(
            ObdSessionServiceInterface::class,
            ObdSessionService::class,
        );
    }

    public function boot(): void
    {
        $this->loadMigrationsFrom(
            __DIR__.'/../Database/Migrations',
        );

        if (is_file(__DIR__.'/../Routes/api.php')) {
            $this->loadRoutesFrom(
                __DIR__.'/../Routes/api.php',
            );
        }
    }
}
