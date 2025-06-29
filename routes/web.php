<?php

declare(strict_types=1);

use App\Enums\SocialiteDriver;
use App\Http\Controllers\Identity\CallbackController;
use App\Http\Controllers\Identity\RedirectController;
use App\Http\Middleware\InitializePaddle;
use App\Http\Middleware\RedirectLocalHost;
use App\Notifications\MagicLink;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/', fn () => inertia('Home', [
    'plans' => config('subscription.plans'),
]))->middleware(InitializePaddle::class)->name('home');

Route::prefix('{driver}')
    ->whereIn('driver', SocialiteDriver::cases())
    ->name('identities.')
    ->middleware('guest')
    ->group(function () {
        Route::get('redirect', RedirectController::class)->name('redirect');
        Route::get('callback', CallbackController::class)->middleware(RedirectLocalHost::class)->name('callback');
    });

Route::get('/dashboard', fn () => inertia('Dashboard'))->middleware('auth')->name('dashboard');

Route::post('/login/link', function (Request $request) {
    $user = App\Models\User::query()
        ->where('email', $request->string('email'))
        ->firstOrFail();

    $user->notify(new MagicLink($user));

    return redirect()->back()->with([
        'toast' => 'Magic link sent. Please check your email.',
    ]);
})->name('login.link.store');

Route::get('/login/link/{user}', function (App\Models\User $user) {
    Illuminate\Support\Facades\Auth::login($user);

    return to_route('dashboard');
})->middleware('signed')->name('login.link.show');
