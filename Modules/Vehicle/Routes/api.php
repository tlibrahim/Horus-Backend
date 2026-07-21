<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;
use Modules\Vehicle\Http\Controllers\Api\Catalog\BodyTypeController;
use Modules\Vehicle\Http\Controllers\Api\Catalog\BrandController;
use Modules\Vehicle\Http\Controllers\Api\Catalog\DriveTypeController;
use Modules\Vehicle\Http\Controllers\Api\Catalog\EngineController;
use Modules\Vehicle\Http\Controllers\Api\Catalog\FuelTypeController;
use Modules\Vehicle\Http\Controllers\Api\Catalog\GenerationController;
use Modules\Vehicle\Http\Controllers\Api\Catalog\TransmissionController;
use Modules\Vehicle\Http\Controllers\Api\Catalog\VehicleModelController;
use Modules\Vehicle\Http\Controllers\Api\Catalog\VehicleTypeController;
use Modules\Vehicle\Http\Controllers\Api\OBD\ObdDeviceController;
use Modules\Vehicle\Http\Controllers\Api\OBD\VehicleObdDeviceController;
use Modules\Vehicle\Http\Controllers\Api\VehicleController;
use Modules\Vehicle\Http\Controllers\Api\VehicleDocumentController;
use Modules\Vehicle\Http\Controllers\Api\VehicleImageController;
use Modules\Vehicle\Http\Controllers\Api\VehicleOwnerController;

Route::prefix('api/v1/vehicle')
    ->middleware('api')
    ->name('api.v1.vehicle.')
    ->group(function (): void {
        Route::prefix('brands')
            ->name('brands.')
            ->controller(BrandController::class)
            ->group(function (): void {
                Route::get('/', 'index')->name('index');
                Route::get('/options', 'options')->name('options');
                Route::post('/', 'store')->name('store');
                Route::get('/{brand}', 'show')->name('show');
                Route::put('/{brand}', 'update')->name('update');
                Route::patch('/{brand}/status', 'toggleStatus')->name('toggleStatus');
                Route::delete('/{brand}', 'destroy')->name('destroy');
            });

        Route::prefix('models')
            ->name('models.')
            ->controller(VehicleModelController::class)
            ->group(function (): void {
                Route::get('/', 'index')->name('index');
                Route::get('/options', 'options')->name('options');
                Route::post('/', 'store')->name('store');
                Route::get('/{vehicleModel}', 'show')->name('show');
                Route::put('/{vehicleModel}', 'update')->name('update');
                Route::patch('/{vehicleModel}/status', 'toggleStatus')->name('toggleStatus');
                Route::delete('/{vehicleModel}', 'destroy')->name('destroy');
            });

        Route::prefix('generations')
            ->name('generations.')
            ->controller(GenerationController::class)
            ->group(function (): void {
                Route::get('/', 'index')->name('index');
                Route::get('/options', 'options')->name('options');
                Route::post('/', 'store')->name('store');
                Route::get('/{generation}', 'show')->name('show');
                Route::put('/{generation}', 'update')->name('update');
                Route::patch('/{generation}/status', 'toggleStatus')->name('toggleStatus');
                Route::delete('/{generation}', 'destroy')->name('destroy');
            });

        Route::prefix('engines')
            ->name('engines.')
            ->controller(EngineController::class)
            ->group(function (): void {
                Route::get('/', 'index')->name('index');
                Route::get('/options', 'options')->name('options');
                Route::post('/', 'store')->name('store');
                Route::get('/{engine}', 'show')->name('show');
                Route::put('/{engine}', 'update')->name('update');
                Route::patch('/{engine}/status', 'toggleStatus')->name('toggleStatus');
                Route::delete('/{engine}', 'destroy')->name('destroy');
            });

        Route::prefix('fuel-types')
            ->name('fuelTypes.')
            ->controller(FuelTypeController::class)
            ->group(function (): void {
                Route::get('/', 'index')->name('index');
                Route::get('/options', 'options')->name('options');
                Route::get('/{fuelType}', 'show')->name('show');
            });

        Route::prefix('transmissions')
            ->name('transmissions.')
            ->controller(TransmissionController::class)
            ->group(function (): void {
                Route::get('/', 'index')->name('index');
                Route::get('/options', 'options')->name('options');
                Route::get('/{transmission}', 'show')->name('show');
            });

        Route::prefix('drive-types')
            ->name('driveTypes.')
            ->controller(DriveTypeController::class)
            ->group(function (): void {
                Route::get('/', 'index')->name('index');
                Route::get('/options', 'options')->name('options');
                Route::get('/{driveType}', 'show')->name('show');
            });

        Route::prefix('body-types')
            ->name('bodyTypes.')
            ->controller(BodyTypeController::class)
            ->group(function (): void {
                Route::get('/', 'index')->name('index');
                Route::get('/options', 'options')->name('options');
                Route::get('/{bodyType}', 'show')->name('show');
            });

        Route::prefix('vehicle-types')
            ->name('vehicleTypes.')
            ->controller(VehicleTypeController::class)
            ->group(function (): void {
                Route::get('/', 'index')->name('index');
                Route::get('/options', 'options')->name('options');
                Route::get('/{vehicleType}', 'show')->name('show');
            });

        Route::prefix('vehicles')
            ->name('vehicles.')
            ->group(function (): void {
                /*
                |--------------------------------------------------------------------------
                | Vehicle CRUD
                |--------------------------------------------------------------------------
                */

                Route::controller(VehicleController::class)
                    ->group(function (): void {

                        Route::get('/', 'index')->name('index');
                        Route::get('/options', 'options')->name('options');
                        Route::post('/', 'store')->name('store');
                        Route::get('/{vehicle}', 'show')->name('show');
                        Route::put('/{vehicle}', 'update')->name('update');
                        Route::delete('/{vehicle}', 'destroy')->name('destroy');
                    });

                /*
                |--------------------------------------------------------------------------
                | Vehicle Images
                |--------------------------------------------------------------------------
                */

                Route::controller(VehicleImageController::class)
                    ->prefix('{vehicle}/images')
                    ->name('images.')
                    ->group(function (): void {

                        Route::get('/', 'index')->name('index');

                        Route::post('/', 'store')->name('store');
                    });

                /*
                |--------------------------------------------------------------------------
                | Vehicle Documents
                |--------------------------------------------------------------------------
                */

                Route::controller(VehicleDocumentController::class)
                    ->prefix('{vehicle}/documents')
                    ->name('documents.')
                    ->group(function (): void {

                        Route::get('/', 'index')->name('index');

                        Route::post('/', 'store')->name('store');
                    });

                /*
            |--------------------------------------------------------------------------
            | Vehicle Owner
            |--------------------------------------------------------------------------
            */

                Route::controller(VehicleOwnerController::class)
                    ->prefix('{vehicle}/owners')
                    ->name('owners.')
                    ->group(function (): void {

                        Route::get('/', 'index')
                            ->name('index');

                        Route::post('/', 'store')
                            ->name('store');
                    });
            });

        Route::prefix('vehicle-images')
            ->name('vehicle-images.')
            ->controller(VehicleImageController::class)
            ->group(function (): void {

                Route::get('/{vehicleImage}', 'show')->name('show');

                Route::patch('/{vehicleImage}', 'update')->name('update');

                Route::delete('/{vehicleImage}', 'destroy')->name('destroy');

                Route::patch('/{vehicleImage}/primary', 'setPrimary')
                    ->name('set-primary');
            });

        Route::prefix('vehicle-documents')
            ->name('vehicle-documents.')
            ->controller(VehicleDocumentController::class)
            ->group(function (): void {

                Route::get('/{vehicleDocument}', 'show')
                    ->name('show');

                Route::patch('/{vehicleDocument}', 'update')
                    ->name('update');

                Route::delete('/{vehicleDocument}', 'destroy')
                    ->name('destroy');
            });

        Route::prefix('vehicle-owners')
            ->name('vehicle-owners.')
            ->controller(VehicleOwnerController::class)
            ->group(function (): void {

                Route::get('/{vehicleOwner}', 'show')
                    ->name('show');

                Route::patch('/{vehicleOwner}', 'update')
                    ->name('update');

                Route::delete('/{vehicleOwner}', 'destroy')
                    ->name('destroy');
            });

        Route::prefix('obd-devices')
            ->name('obd-devices.')
            ->controller(ObdDeviceController::class)
            ->group(function (): void {
                Route::get('/', 'index')->name('index');
                Route::get('/options', 'options')->name('options');
                Route::post('/', 'store')->name('store');
                Route::get('/{obdDevice}', 'show')->name('show');
                Route::put('/{obdDevice}', 'update')->name('update');
                Route::patch('/{obdDevice}/toggle-status', 'toggleStatus')
                    ->name('toggleStatus');
                Route::delete('/{obdDevice}', 'destroy')->name('destroy');
            });

        Route::prefix('vehicles/{vehicle}/obd-devices')
            ->name('vehicle-obd-devices.')
            ->controller(VehicleObdDeviceController::class)
            ->group(function (): void {
                Route::post('/', 'pair')
                    ->name('pair');

                Route::delete('/{obdDevice}', 'unpair')
                    ->name('unpair');

                Route::get('/current', 'current')
                    ->name('current');

                Route::get('/history', 'history')
                    ->name('history');
            });
    });
