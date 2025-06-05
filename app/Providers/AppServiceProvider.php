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

        if ($this->app->runningUnitTests()) {
            $this->configureTestingEnvironment();
        }

        if ($this->app->isProduction()) {
            $this->configureProductionEnvironment();
        }
    }

    public function configureEloquent(): void
    {
        Model::unguard();
        Model::preventLazyLoading();
        Model::preventAccessingMissingAttributes();
        Model::preventSilentlyDiscardingAttributes();
        Model::automaticallyEagerLoadRelationships();
    }

    public function configureTestingEnvironment(): void
    {
        Sleep::fake();
        Http::preventStrayRequests();
    }

    public function configureVite(): void
    {
        Vite::useAggressivePrefetching();
    }

    public function configureCarbon(): void
    {
        Date::use(CarbonImmutable::class);
    }

    public function configureProductionEnvironment(): void
    {
        URL::forceHttps();
        DB::prohibitDestructiveCommands();
    }

    public function configurePasswords(): void
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
