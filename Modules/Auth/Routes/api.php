<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;
use Modules\Auth\Http\Controllers\Api\AuthController;
use Modules\Auth\Http\Controllers\Api\PermissionController;
use Modules\Auth\Http\Controllers\Api\RoleController;

Route::prefix('api/v1/auth')
    ->middleware('api')
    ->name('api.v1.auth.')
    ->group(function (): void {
        Route::controller(AuthController::class)
            ->group(function (): void {
                Route::post('/register', 'register')->name('register');
                Route::post('/verify-otp', 'verifyOtp')->name('verifyOtp');
                Route::post('/resend-otp', 'resendOtp')->name('resendOtp');
                Route::post('/login', 'login')->name('login');
                Route::post('/refresh', 'refresh')->name('refresh');
                Route::post('/forgot-password', 'forgotPassword')->name('forgotPassword');
                Route::post('/reset-password', 'resetPassword')->name('resetPassword');

                Route::middleware('auth.token')->group(function (): void {
                    Route::post('/logout', 'logout')->name('logout');
                    Route::post('/logout-all', 'logoutAll')->name('logoutAll');
                    Route::post('/change-password', 'changePassword')->name('changePassword');
                    Route::get('/me', 'me')->name('me');
                });
            });

        Route::prefix('roles')
            ->name('roles.')
            ->controller(RoleController::class)
            ->group(function (): void {
                Route::get('/', 'index')->name('index');
                Route::get('/options', 'options')->name('options');
                Route::post('/', 'store')->name('store');
                Route::get('/{role}', 'show')->name('show');
                Route::put('/{role}', 'update')->name('update');
                Route::patch('/{role}/status', 'toggleStatus')->name('toggleStatus');
                Route::patch('/{role}/activate', 'activate')->name('activate');
                Route::patch('/{role}/deactivate', 'deactivate')->name('deactivate');
                Route::get('/{role}/permissions', 'permissions')->name('permissions');
                Route::put('/{role}/permissions', 'syncPermissions')->name('syncPermissions');
                Route::delete('/{role}', 'destroy')->name('destroy');
            });

        Route::prefix('permissions')
            ->name('permissions.')
            ->controller(PermissionController::class)
            ->group(function (): void {
                Route::get('/', 'index')->name('index');
                Route::get('/options', 'options')->name('options');
                Route::post('/', 'store')->name('store');
                Route::get('/{permission}', 'show')->name('show');
                Route::put('/{permission}', 'update')->name('update');
                Route::delete('/{permission}', 'destroy')->name('destroy');
            });
    });
