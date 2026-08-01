<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;
use Modules\OBD\Http\Controllers\Api\ObdDeviceController;
use Modules\OBD\Http\Controllers\Api\ObdSessionController;
use Modules\OBD\Http\Controllers\Api\VehicleObdDeviceController;

Route::prefix('api/v1/obd')
    ->middleware('api')
    ->name('api.v1.obd.')
    ->group(function (): void {

        Route::prefix('devices')
            ->name('devices.')
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

        Route::prefix('vehicles/{vehicle}/devices')
            ->name('vehicles.devices.')
            ->controller(VehicleObdDeviceController::class)
            ->group(function (): void {
                Route::post('/', 'pair')->name('pair');

                Route::delete('/{obdDevice}', 'unpair')->name('unpair');

                Route::get('/current', 'current')->name('current');

                Route::get('/history', 'history')->name('history');
            });

        Route::prefix('sessions')
            ->name('sessions.')
            ->controller(ObdSessionController::class)
            ->group(function (): void {
                Route::get('/', 'index')->name('index');

                Route::get('/options', 'options')->name('options');

                Route::post('/', 'store')->name('store');

                Route::get('/{obdSession}', 'show')->name('show');

                Route::put('/{obdSession}', 'update')->name('update');

                Route::patch(
                    '/{obdSession}/toggle-status',
                    'toggleStatus'
                )->name('toggleStatus');

                Route::delete(
                    '/{obdSession}',
                    'destroy'
                )->name('destroy');

                /*
                |--------------------------------------------------------------------------
                | Session Lifecycle
                |--------------------------------------------------------------------------
                */

                Route::post(
                    '/pairings/{pairing}/connect',
                    'connect'
                )->name('pairings.connect');

                Route::patch(
                    '/{obdSession}/heartbeat',
                    'heartbeat'
                )->name('heartbeat');

                Route::patch(
                    '/{obdSession}/disconnect',
                    'disconnect'
                )->name('disconnect');

                Route::get(
                    '/pairings/{pairing}/active',
                    'active'
                )->name('pairings.active');

                Route::get(
                    '/pairings/{pairing}/history',
                    'history'
                )->name('pairings.history');
            });
    });
