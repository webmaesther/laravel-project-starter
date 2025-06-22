<?php

// @codeCoverageIgnoreStart

declare(strict_types=1);

namespace App\Providers;

use App\Actions\Fortify\CreateNewUser;
use App\Actions\Fortify\ResetUserPassword;
use App\Actions\Fortify\UpdateUserPassword;
use App\Actions\Fortify\UpdateUserProfileInformation;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;
use Laravel\Fortify\Contracts\LoginResponse;
use Laravel\Fortify\Contracts\LogoutResponse;
use Laravel\Fortify\Contracts\RegisterResponse;
use Laravel\Fortify\Fortify;
use Override;

final class FortifyServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    #[Override]
    public function register(): void
    {
        $this->app->instance(LoginResponse::class, new class implements LoginResponse
        {
            public function toResponse(
                $request // @pest-ignore-type
            ): RedirectResponse {
                return to_route('dashboard');
            }
        });

        $this->app->instance(LogoutResponse::class, new class implements LogoutResponse
        {
            public function toResponse(
                $request // @pest-ignore-type
            ): RedirectResponse {
                return to_route('home');
            }
        });

        $this->app->instance(RegisterResponse::class, new class implements RegisterResponse
        {
            public function toResponse(
                $request // @pest-ignore-type
            ): RedirectResponse {
                return to_route('dashboard');
            }
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Fortify::createUsersUsing(CreateNewUser::class);
        Fortify::updateUserProfileInformationUsing(UpdateUserProfileInformation::class);
        Fortify::updateUserPasswordsUsing(UpdateUserPassword::class);
        Fortify::resetUserPasswordsUsing(ResetUserPassword::class);

        Fortify::loginView(fn () => inertia('Login'));

        Fortify::registerView(fn () => inertia('Register'));

        RateLimiter::for('login', function (Request $request) {
            $throttleKey = Str::transliterate(Str::lower((string) $request->string(Fortify::username())).'|'.$request->ip());

            return Limit::perMinute(5)->by($throttleKey);
        });

        RateLimiter::for('two-factor', fn (Request $request) => Limit::perMinute(5)->by($request->session()->get('login.id')));
    }
}

// @codeCoverageIgnoreEnd
