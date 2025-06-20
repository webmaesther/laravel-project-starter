<?php

// @codeCoverageIgnoreStart

declare(strict_types=1);

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use Laravel\Telescope\Telescope;
use Laravel\Telescope\TelescopeApplicationServiceProvider;
use Override;

final class TelescopeServiceProvider extends TelescopeApplicationServiceProvider
{
    /**
     * Register any application services.
     */
    #[Override]
    public function register(): void
    {
        if (! $this->app->isLocal()) {
            return;
        }

        $this->app->register(\Laravel\Telescope\TelescopeServiceProvider::class);

        Telescope::night();
    }

    public function boot(): void
    {
        if (! $this->app->isLocal()) {
            return;
        }

        parent::boot();
    }

    /**
     * Register the Telescope gate.
     *
     * This gate determines who can access Telescope in non-local environments.
     */
    #[Override]
    protected function gate(): void
    {
        Gate::define('viewTelescope', fn ($user): false => false);
    }
}

// @codeCoverageIgnoreEnd
