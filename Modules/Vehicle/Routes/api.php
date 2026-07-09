<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;
use Modules\Vehicle\Http\Controllers\Api\BodyTypeController;
use Modules\Vehicle\Http\Controllers\Api\BrandController;
use Modules\Vehicle\Http\Controllers\Api\DriveTypeController;
use Modules\Vehicle\Http\Controllers\Api\EngineController;
use Modules\Vehicle\Http\Controllers\Api\FuelTypeController;
use Modules\Vehicle\Http\Controllers\Api\GenerationController;
use Modules\Vehicle\Http\Controllers\Api\TransmissionController;
use Modules\Vehicle\Http\Controllers\Api\VehicleModelController;
use Modules\Vehicle\Http\Controllers\Api\VehicleTypeController;

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
    });
