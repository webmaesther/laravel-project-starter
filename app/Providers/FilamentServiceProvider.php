<?php

declare(strict_types=1);

namespace App\Providers;

use App\Policies\PanelPolicy;
use Filament\Panel;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

final class FilamentServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        Gate::policy(Panel::class, PanelPolicy::class);
    }
}
