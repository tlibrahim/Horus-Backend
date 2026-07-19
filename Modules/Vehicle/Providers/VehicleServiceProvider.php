<?php

declare(strict_types=1);

namespace Modules\Vehicle\Providers;

use Illuminate\Support\ServiceProvider;
use Modules\Vehicle\Contracts\BodyType\BodyTypeRepositoryInterface;
use Modules\Vehicle\Contracts\BodyType\BodyTypeServiceInterface;
use Modules\Vehicle\Contracts\Brand\BrandRepositoryInterface;
use Modules\Vehicle\Contracts\Brand\BrandServiceInterface;
use Modules\Vehicle\Contracts\DriveType\DriveTypeRepositoryInterface;
use Modules\Vehicle\Contracts\DriveType\DriveTypeServiceInterface;
use Modules\Vehicle\Contracts\Engine\EngineRepositoryInterface;
use Modules\Vehicle\Contracts\Engine\EngineServiceInterface;
use Modules\Vehicle\Contracts\FuelType\FuelTypeRepositoryInterface;
use Modules\Vehicle\Contracts\FuelType\FuelTypeServiceInterface;
use Modules\Vehicle\Contracts\Generation\GenerationRepositoryInterface;
use Modules\Vehicle\Contracts\Generation\GenerationServiceInterface;
use Modules\Vehicle\Contracts\Transmission\TransmissionRepositoryInterface;
use Modules\Vehicle\Contracts\Transmission\TransmissionServiceInterface;
use Modules\Vehicle\Contracts\Vehicle\VehicleRepositoryInterface;
use Modules\Vehicle\Contracts\Vehicle\VehicleServiceInterface;
use Modules\Vehicle\Contracts\VehicleDocument\VehicleDocumentRepositoryInterface;
use Modules\Vehicle\Contracts\VehicleDocument\VehicleDocumentServiceInterface;
use Modules\Vehicle\Contracts\VehicleImage\VehicleImageRepositoryInterface;
use Modules\Vehicle\Contracts\VehicleImage\VehicleImageServiceInterface;
use Modules\Vehicle\Contracts\VehicleModel\VehicleModelRepositoryInterface;
use Modules\Vehicle\Contracts\VehicleModel\VehicleModelServiceInterface;
use Modules\Vehicle\Contracts\VehicleType\VehicleTypeRepositoryInterface;
use Modules\Vehicle\Contracts\VehicleType\VehicleTypeServiceInterface;
use Modules\Vehicle\Repositories\BodyTypeRepository;
use Modules\Vehicle\Repositories\BrandRepository;
use Modules\Vehicle\Repositories\DriveTypeRepository;
use Modules\Vehicle\Repositories\EngineRepository;
use Modules\Vehicle\Repositories\FuelTypeRepository;
use Modules\Vehicle\Repositories\GenerationRepository;
use Modules\Vehicle\Repositories\TransmissionRepository;
use Modules\Vehicle\Repositories\VehicleDocumentRepository;
use Modules\Vehicle\Repositories\VehicleImageRepository;
use Modules\Vehicle\Repositories\VehicleModelRepository;
use Modules\Vehicle\Repositories\VehicleRepository;
use Modules\Vehicle\Repositories\VehicleTypeRepository;
use Modules\Vehicle\Services\BodyTypeService;
use Modules\Vehicle\Services\BrandService;
use Modules\Vehicle\Services\DriveTypeService;
use Modules\Vehicle\Services\EngineService;
use Modules\Vehicle\Services\FuelTypeService;
use Modules\Vehicle\Services\GenerationService;
use Modules\Vehicle\Services\TransmissionService;
use Modules\Vehicle\Services\VehicleDocumentService;
use Modules\Vehicle\Services\VehicleImageService;
use Modules\Vehicle\Services\VehicleModelService;
use Modules\Vehicle\Services\VehicleService;
use Modules\Vehicle\Services\VehicleTypeService;

final class VehicleServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->singleton(
            BrandRepositoryInterface::class,
            BrandRepository::class,
        );

        $this->app->singleton(
            VehicleModelRepositoryInterface::class,
            VehicleModelRepository::class,
        );

        $this->app->singleton(
            GenerationRepositoryInterface::class,
            GenerationRepository::class,
        );

        $this->app->singleton(
            EngineRepositoryInterface::class,
            EngineRepository::class,
        );

        $this->app->singleton(
            FuelTypeRepositoryInterface::class,
            FuelTypeRepository::class,
        );

        $this->app->singleton(
            TransmissionRepositoryInterface::class,
            TransmissionRepository::class,
        );

        $this->app->singleton(
            DriveTypeRepositoryInterface::class,
            DriveTypeRepository::class,
        );

        $this->app->singleton(
            BodyTypeRepositoryInterface::class,
            BodyTypeRepository::class,
        );

        $this->app->singleton(
            VehicleTypeRepositoryInterface::class,
            VehicleTypeRepository::class,
        );

        $this->app->singleton(
            BrandServiceInterface::class,
            BrandService::class,
        );

        $this->app->singleton(
            VehicleModelServiceInterface::class,
            VehicleModelService::class,
        );

        $this->app->singleton(
            GenerationServiceInterface::class,
            GenerationService::class,
        );

        $this->app->singleton(
            EngineServiceInterface::class,
            EngineService::class,
        );

        $this->app->singleton(
            FuelTypeServiceInterface::class,
            FuelTypeService::class,
        );

        $this->app->singleton(
            VehicleDocumentRepositoryInterface::class,
            VehicleDocumentRepository::class,
        );

        $this->app->singleton(
            VehicleDocumentServiceInterface::class,
            VehicleDocumentService::class,
        );

        $this->app->singleton(
            TransmissionServiceInterface::class,
            TransmissionService::class,
        );

        $this->app->singleton(
            DriveTypeServiceInterface::class,
            DriveTypeService::class,
        );

        $this->app->singleton(
            BodyTypeServiceInterface::class,
            BodyTypeService::class,
        );

        $this->app->singleton(
            VehicleTypeServiceInterface::class,
            VehicleTypeService::class,
        );

        $this->app->singleton(
            VehicleRepositoryInterface::class,
            VehicleRepository::class,
        );

        $this->app->singleton(
            VehicleServiceInterface::class,
            VehicleService::class,
        );

        $this->app->singleton(
            VehicleImageRepositoryInterface::class,
            VehicleImageRepository::class,
        );

        $this->app->singleton(
            VehicleImageServiceInterface::class,
            VehicleImageService::class,
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
    }
}
