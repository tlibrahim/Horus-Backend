<?php

declare(strict_types=1);

namespace Modules\Auth\Providers;

use Illuminate\Support\ServiceProvider;
use Modules\Auth\Contracts\Repositories\PermissionRepositoryInterface;
use Modules\Auth\Contracts\Repositories\RoleRepositoryInterface;
use Modules\Auth\Contracts\Services\AuthServiceInterface;
use Modules\Auth\Contracts\Services\PermissionServiceInterface;
use Modules\Auth\Contracts\Services\RoleServiceInterface;
use Modules\Auth\Repositories\PermissionRepository;
use Modules\Auth\Repositories\RoleRepository;
use Modules\Auth\Services\AuthService;
use Modules\Auth\Services\PermissionService;
use Modules\Auth\Services\RoleService;

final class AuthServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->mergeConfigFrom(
            __DIR__.'/../Config/auth.php',
            'auth',
        );

        $this->app->singleton(
            RoleRepositoryInterface::class,
            RoleRepository::class,
        );

        $this->app->singleton(
            PermissionRepositoryInterface::class,
            PermissionRepository::class,
        );

        $this->app->singleton(
            RoleServiceInterface::class,
            RoleService::class,
        );

        $this->app->singleton(
            PermissionServiceInterface::class,
            PermissionService::class,
        );

        $this->app->singleton(
            AuthServiceInterface::class,
            AuthService::class,
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

        if (is_file(__DIR__.'/../Routes/web.php')) {
            $this->loadRoutesFrom(
                __DIR__.'/../Routes/web.php',
            );
        }

        $this->publishes([
            __DIR__.'/../Config/auth.php' => config_path('auth.php'),
        ], 'auth-config');
    }
}
