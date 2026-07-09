<?php

declare(strict_types=1);

namespace Modules\IAM\Providers;

use Illuminate\Support\ServiceProvider;
use Modules\IAM\Contracts\Repositories\PermissionRepositoryInterface;
use Modules\IAM\Contracts\Repositories\RoleRepositoryInterface;
use Modules\IAM\Contracts\Services\AuthServiceInterface;
use Modules\IAM\Contracts\Services\PermissionServiceInterface;
use Modules\IAM\Contracts\Services\RoleServiceInterface;
use Modules\IAM\Repositories\PermissionRepository;
use Modules\IAM\Repositories\RoleRepository;
use Modules\IAM\Services\AuthService;
use Modules\IAM\Services\PermissionService;
use Modules\IAM\Services\RoleService;

final class IAMServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->mergeConfigFrom(
            __DIR__.'/../Config/iam.php',
            'iam',
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
            __DIR__.'/../Config/iam.php' => config_path('iam.php'),
        ], 'iam-config');
    }
}
