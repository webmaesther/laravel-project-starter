<?php

declare(strict_types=1);

use App\Http\Middleware\ForceJsonResponse;
use App\Http\Middleware\HandleInertiaRequests;
use App\Providers\TelescopeServiceProvider;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        channels: __DIR__.'/../routes/channels.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware
            ->statefulApi()
            ->validateCsrfTokens(except: [
                'paddle/*',
            ])
            ->api(prepend: [
                ForceJsonResponse::class,
            ])
            ->web(append: [
                HandleInertiaRequests::class,
            ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        $exceptions->render(function (NotFoundHttpException $e, Request $request): ?JsonResponse {
            if ($request->wantsJson()) {
                return response()->json([
                    'message' => 'Not Found',
                ], 404);
            }

            return null;
        });
    })->registered(function (Application $app): void {
        if ($app->isLocal()) {
            $app->register(Laravel\Telescope\TelescopeServiceProvider::class);
            $app->register(TelescopeServiceProvider::class);
        }
    })->create();
