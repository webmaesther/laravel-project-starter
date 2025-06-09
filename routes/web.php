<?php

declare(strict_types=1);

use App\User\Enums\SocialiteDriver;
use App\User\Http\Controllers\FederatedLoginController;
use App\User\Http\Middleware\RedirectLocalHost;
use Illuminate\Support\Facades\Route;

Route::get('/', fn () => inertia('Home'))->name('home');
Route::get('/auth', fn () => inertia('Auth'))->name('auth');

Route::prefix('{driver}')
    ->whereIn('driver', SocialiteDriver::cases())
    ->name('federated.')
    ->group(function () {
        Route::get('redirect', [FederatedLoginController::class, 'redirect'])->name('redirect');
        Route::get('callback', [FederatedLoginController::class, 'callback'])->middleware(RedirectLocalHost::class)->name('callback');
    });
