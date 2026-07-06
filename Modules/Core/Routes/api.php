<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;
use Modules\Core\Http\Controllers\Api\CityController;
use Modules\Core\Http\Controllers\Api\CountryController;
use Modules\Core\Http\Controllers\Api\CurrencyController;
use Modules\Core\Http\Controllers\Api\DistrictController;
use Modules\Core\Http\Controllers\Api\LanguageController;
use Modules\Core\Http\Controllers\Api\TimezoneController;

Route::prefix('api/v1/core')
    ->middleware('api')
    ->name('api.v1.core.')
    ->group(function (): void {

        Route::prefix('countries')
            ->name('countries.')
            ->controller(CountryController::class)
            ->group(function (): void {

                Route::get('/', 'index')
                    ->name('index');

                Route::get('/options', 'options')
                    ->name('options');

                Route::post('/', 'store')
                    ->name('store');

                Route::get('/{country}', 'show')
                    ->name('show');

                Route::put('/{country}', 'update')
                    ->name('update');

                Route::patch('/{country}/status', 'toggleStatus')
                    ->name('toggleStatus');

                Route::delete('/{country}', 'destroy')
                    ->name('destroy');

            });

        Route::prefix('cities')
            ->name('cities.')
            ->controller(CityController::class)
            ->group(function (): void {

                Route::get('/', 'index')
                    ->name('index');

                Route::get('/options', 'options')
                    ->name('options');

                Route::post('/', 'store')
                    ->name('store');

                Route::get('/{city}', 'show')
                    ->name('show');

                Route::put('/{city}', 'update')
                    ->name('update');

                Route::patch('/{city}/status', 'toggleStatus')
                    ->name('toggleStatus');

                Route::delete('/{city}', 'destroy')
                    ->name('destroy');

            });

        Route::prefix('currencies')
            ->name('currencies.')
            ->controller(CurrencyController::class)
            ->group(function (): void {

                Route::get('/', 'index')
                    ->name('index');

                Route::get('/options', 'options')
                    ->name('options');

                Route::post('/', 'store')
                    ->name('store');

                Route::get('/{currency}', 'show')
                    ->name('show');

                Route::put('/{currency}', 'update')
                    ->name('update');

                Route::patch('/{currency}/status', 'toggleStatus')
                    ->name('toggleStatus');

                Route::delete('/{currency}', 'destroy')
                    ->name('destroy');

            });

        Route::prefix('districts')
            ->name('districts.')
            ->controller(DistrictController::class)
            ->group(function (): void {

                Route::get('/', 'index')
                    ->name('index');

                Route::get('/options', 'options')
                    ->name('options');

                Route::post('/', 'store')
                    ->name('store');

                Route::get('/{district}', 'show')
                    ->name('show');

                Route::put('/{district}', 'update')
                    ->name('update');

                Route::patch('/{district}/status', 'toggleStatus')
                    ->name('toggleStatus');

                Route::delete('/{district}', 'destroy')
                    ->name('destroy');

            });

        Route::prefix('languages')
            ->name('languages.')
            ->controller(LanguageController::class)
            ->group(function (): void {

                Route::get('/', 'index')
                    ->name('index');

                Route::get('/options', 'options')
                    ->name('options');

                Route::post('/', 'store')
                    ->name('store');

                Route::get('/{language}', 'show')
                    ->name('show');

                Route::put('/{language}', 'update')
                    ->name('update');

                Route::patch('/{language}/status', 'toggleStatus')
                    ->name('toggleStatus');

                Route::delete('/{language}', 'destroy')
                    ->name('destroy');

            });

        Route::prefix('timezones')
            ->name('timezones.')
            ->controller(TimezoneController::class)
            ->group(function (): void {

                Route::get('/', 'index')
                    ->name('index');

                Route::get('/options', 'options')
                    ->name('options');

                Route::post('/', 'store')
                    ->name('store');

                Route::get('/{timezone}', 'show')
                    ->name('show');

                Route::put('/{timezone}', 'update')
                    ->name('update');

                Route::patch('/{timezone}/status', 'toggleStatus')
                    ->name('toggleStatus');

                Route::delete('/{timezone}', 'destroy')
                    ->name('destroy');

            });

    });
