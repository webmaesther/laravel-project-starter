<?php

declare(strict_types=1);

use App\Http\Middleware\UnlessProduction;
use App\Playwright\Http\Controllers\Api\CommandsController;
use App\Playwright\Http\Controllers\Api\FactoriesController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::name('api.')->group(function () {
    Route::get('/user', fn (Request $request) => $request->user())->middleware('auth:sanctum');

    Route::prefix('_playwright')
        ->name('playwright.')
        ->middleware(UnlessProduction::class)
        ->group(function () {
            Route::resource('factories', FactoriesController::class)->only('store');
            Route::resource('commands', CommandsController::class)->only('store');
        });
});
