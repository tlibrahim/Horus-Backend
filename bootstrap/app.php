<?php

declare(strict_types=1);

use App\Support\Exceptions\BusinessException;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Modules\IAM\Http\Middleware\IamAuthenticate;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->alias([
            'iam.auth' => IamAuthenticate::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {

        /*
        |--------------------------------------------------------------------------
        | Always return JSON for API requests
        |--------------------------------------------------------------------------
        */

        $exceptions->shouldRenderJsonWhen(
            fn (Request $request): bool => $request->is('api/*'),
        );

        /*
        |--------------------------------------------------------------------------
        | Business Exceptions (RFC 7807)
        |--------------------------------------------------------------------------
        */

        $exceptions->render(
            function (
                BusinessException $e,
                Request $request,
            ): JsonResponse {

                return response()->json([
                    'success' => false,
                    'error' => [
                        'type' => $e->type(),
                        'title' => $e->title(),
                        'status' => $e->status(),
                        'detail' => $e->detail(),
                        'instance' => $request->path(),
                    ],
                ], $e->status());
            }
        );
    })
    ->create();
