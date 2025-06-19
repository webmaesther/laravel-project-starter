<?php

declare(strict_types=1);

use App\Enums\SocialiteDriver;
use App\Http\Controllers\Identity\CallbackController;
use App\Http\Controllers\Identity\RedirectController;
use App\Http\Middleware\RedirectLocalHost;
use Illuminate\Support\Facades\Route;

Route::get('/', fn () => inertia('Home'))->name('home');

Route::get('/login', fn () => inertia('Login'))->middleware('guest')->name('login');
Route::get('/register', fn () => inertia('Register'))->middleware('guest')->name('register');

Route::prefix('{driver}')
    ->whereIn('driver', SocialiteDriver::cases())
    ->name('identities.')
    ->middleware('guest')
    ->group(function () {
        Route::get('redirect', RedirectController::class)->name('redirect');
        Route::get('callback', CallbackController::class)->middleware(RedirectLocalHost::class)->name('callback');
    });

Route::get('/dashboard', fn () => inertia('Dashboard'))->middleware('auth')->name('dashboard');
