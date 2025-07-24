<?php

// @codeCoverageIgnoreStart

declare(strict_types=1);

namespace App\Providers;

use Carbon\CarbonImmutable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Sleep;
use Illuminate\Validation\Rules\Password;
use Override;
use Vite;

final class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    #[Override]
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $this->configureEloquent();
        $this->configureDatabase();
        $this->configurePasswords();
        $this->configureHttp();
        $this->configureTime();
        $this->configureVite();
    }

    private function configureEloquent(): void
    {
        Model::unguard();
        Model::preventLazyLoading();
        Model::preventAccessingMissingAttributes();
        Model::preventSilentlyDiscardingAttributes();
        Model::automaticallyEagerLoadRelationships();
    }

    private function configureVite(): void
    {
        Vite::useAggressivePrefetching();
    }

    private function configureTime(): void
    {
        Date::use(CarbonImmutable::class);
        Sleep::fake($this->app->runningUnitTests());
    }

    private function configureHttp(): void
    {
        URL::forceHttps();
        Http::preventStrayRequests($this->app->runningUnitTests());
    }

    private function configureDatabase(): void
    {
        DB::prohibitDestructiveCommands($this->app->isProduction());
    }

    private function configurePasswords(): void
    {
        Password::defaults(function (): ?Password {
            if (! $this->app->isProduction()) {
                return null;
            }

            return Password::min(12)
                ->max(255)
                ->letters()
                ->numbers()
                ->symbols()
                ->mixedCase()
                ->uncompromised();
        });
    }
}

// @codeCoverageIgnoreEnd
