<?php

declare(strict_types=1);

namespace Modules\Core\Providers;

use Illuminate\Support\ServiceProvider;
use Modules\Core\Contracts\CityRepositoryInterface;
use Modules\Core\Contracts\CityServiceInterface;
use Modules\Core\Contracts\CountryRepositoryInterface;
use Modules\Core\Contracts\CountryServiceInterface;
use Modules\Core\Contracts\CurrencyRepositoryInterface;
use Modules\Core\Contracts\CurrencyServiceInterface;
use Modules\Core\Contracts\DistrictRepositoryInterface;
use Modules\Core\Contracts\DistrictServiceInterface;
use Modules\Core\Contracts\LanguageRepositoryInterface;
use Modules\Core\Contracts\LanguageServiceInterface;
use Modules\Core\Contracts\TimezoneRepositoryInterface;
use Modules\Core\Contracts\TimezoneServiceInterface;
use Modules\Core\Repositories\CityRepository;
use Modules\Core\Repositories\CountryRepository;
use Modules\Core\Repositories\CurrencyRepository;
use Modules\Core\Repositories\DistrictRepository;
use Modules\Core\Repositories\LanguageRepository;
use Modules\Core\Repositories\TimezoneRepository;
use Modules\Core\Services\CityService;
use Modules\Core\Services\CountryService;
use Modules\Core\Services\CurrencyService;
use Modules\Core\Services\DistrictService;
use Modules\Core\Services\LanguageService;
use Modules\Core\Services\TimezoneService;

final class CoreServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->mergeConfigFrom(
            __DIR__.'/../Config/core.php',
            'core',
        );

        $this->app->singleton(
            CountryRepositoryInterface::class,
            CountryRepository::class,
        );

        $this->app->singleton(
            CityRepositoryInterface::class,
            CityRepository::class,
        );

        $this->app->singleton(
            CurrencyRepositoryInterface::class,
            CurrencyRepository::class,
        );

        $this->app->singleton(
            DistrictRepositoryInterface::class,
            DistrictRepository::class,
        );

        $this->app->singleton(
            LanguageRepositoryInterface::class,
            LanguageRepository::class,
        );

        $this->app->singleton(
            TimezoneRepositoryInterface::class,
            TimezoneRepository::class,
        );

        $this->app->singleton(
            CountryServiceInterface::class,
            CountryService::class,
        );

        $this->app->singleton(
            CityServiceInterface::class,
            CityService::class,
        );

        $this->app->singleton(
            CurrencyServiceInterface::class,
            CurrencyService::class,
        );

        $this->app->singleton(
            DistrictServiceInterface::class,
            DistrictService::class,
        );

        $this->app->singleton(
            LanguageServiceInterface::class,
            LanguageService::class,
        );

        $this->app->singleton(
            TimezoneServiceInterface::class,
            TimezoneService::class,
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

        $this->loadTranslationsFrom(
            __DIR__.'/../Lang',
            'core',
        );

        $this->publishes([
            __DIR__.'/../Config/core.php' => config_path('core.php'),
        ], 'core-config');
    }
}
