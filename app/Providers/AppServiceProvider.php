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
        $this->configureVite();
        $this->configureCarbon();
        $this->configurePasswords();
        $this->configureHttps();

        if ($this->app->runningUnitTests()) {
            $this->configureTestingEnvironment();
        }

        if ($this->app->isProduction()) {
            $this->configureProductionEnvironment();
        }
    }

    private function configureEloquent(): void
    {
        Model::unguard();
        Model::preventLazyLoading();
        Model::preventAccessingMissingAttributes();
        Model::preventSilentlyDiscardingAttributes();
        Model::automaticallyEagerLoadRelationships();
    }

    private function configureTestingEnvironment(): void
    {
        Sleep::fake();
        Http::preventStrayRequests();
    }

    private function configureVite(): void
    {
        Vite::useAggressivePrefetching();
    }

    private function configureCarbon(): void
    {
        Date::use(CarbonImmutable::class);
    }

    private function configureHttps(): void
    {
        URL::forceHttps();
    }

    private function configureProductionEnvironment(): void
    {
        DB::prohibitDestructiveCommands();
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
