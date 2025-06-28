<?php

declare(strict_types=1);

use App\Http\Controllers\Api\CommandsController;
use App\Http\Controllers\Api\FactoriesController;
use App\Http\Middleware\UnlessProduction;
use Illuminate\Container\Attributes\CurrentUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::name('api.')->group(function () {
    Route::get('/checkout/{subscription}/{price}', function (#[CurrentUser] App\Models\User $user, string $subscription, string $price) {
        $checkout = $user->subscribe($price, $subscription)->returnTo(route('home'));

        $customer = $checkout->getCustomer();

        return [
            'items' => $checkout->getItems(),
            'customer' => [
                'id' => $customer?->paddle_id,
            ],
            'settings' => [
                'successUrl' => $checkout->getReturnUrl(),
            ],
            'customData' => $checkout->getCustomData(),
        ];
    })->name('subscribe');

    Route::get('/user', fn (Request $request) => $request->user())->middleware('auth:sanctum');

    Route::prefix('_playwright')
        ->name('playwright.')
        ->middleware(UnlessProduction::class)
        ->group(function () {
            Route::resource('factories', FactoriesController::class)->only('store');
            Route::resource('commands', CommandsController::class)->only('store');
        });
});
