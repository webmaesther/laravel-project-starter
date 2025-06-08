<?php

declare(strict_types=1);

use App\Playwright\Http\Controllers\Api\CommandsController;
use App\Playwright\Http\Controllers\Api\FactoriesController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', fn (Request $request) => $request->user())->middleware('auth:sanctum');

Route::post('/_playwright/factories', [FactoriesController::class, 'store'])->name('api.playwright.factories.store');
Route::post('/_playwright/commands', [CommandsController::class, 'store'])->name('api.playwright.commands.store');
