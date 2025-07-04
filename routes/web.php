<?php

declare(strict_types=1);

use App\Enums\SocialiteDriver;
use App\Http\Controllers\HomePageController;
use App\Http\Controllers\Identity\CallbackController;
use App\Http\Controllers\Identity\RedirectController;
use App\Http\Controllers\LandingPageController;
use App\Http\Controllers\LoginLinkController;
use App\Http\Middleware\RedirectLocalHost;
use Illuminate\Support\Facades\Route;

Route::get('/', LandingPageController::class)->name('landing');
Route::get('/home', HomePageController::class)->name('home');

Route::prefix('{driver}')
    ->whereIn('driver', SocialiteDriver::cases())
    ->name('identities.')
    ->middleware('guest')
    ->group(function () {
        Route::get('redirect', RedirectController::class)->name('redirect');
        Route::get('callback', CallbackController::class)->middleware(RedirectLocalHost::class)->name('callback');
    });

Route::get('/dashboard', fn () => inertia('Dashboard'))->middleware('auth')->name('dashboard');

Route::prefix('/login/link')
    ->name('login.link.')
    ->controller(LoginLinkController::class)
    ->group(function () {
        Route::post('/', 'store')->name('store');
        Route::get('{user}', 'show')->name('show')->middleware('signed');
    });
