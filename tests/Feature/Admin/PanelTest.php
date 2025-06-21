<?php

declare(strict_types=1);

use App\Models\User;
use App\Policies\PanelPolicy;

use function Pest\Laravel\actingAs;
use function Pest\Laravel\get;

covers(PanelPolicy::class);
covers(User::class);

describe('Admin Panel', function (): void {

    test('guests do not have access', function (): void {

        get(route('filament.admin.pages.dashboard'))
            ->assertRedirect(route('filament.admin.auth.login'));

    });

    test('only I am allowed to access the dashboard', function (): void {

        actingAs(User::factory()->create())
            ->get(route('filament.admin.pages.dashboard'))
            ->assertForbidden();

    });

});
