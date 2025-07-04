<?php

declare(strict_types=1);

use App\Models\User;
use Inertia\Testing\AssertableInertia as Inertia;

use function Pest\Laravel\actingAs;
use function Pest\Laravel\get;

describe('Landing page', function (): void {
    test('returns a successful response', function (): void {
        // Act & Assert
        get(route('landing'))
            ->assertOk();
    });

    test('redirects logged in users to the home page', function (): void {
        // Arrange
        actingAs(User::factory()->create());

        // Act & Assert
        get(route('landing'))
            ->assertRedirect(route('home'));
    });

    test('shows the landing page', function (): void {
        // Act & Assert
        get(route('landing'))
            ->assertInertia(fn (Inertia $inertia): Inertia => $inertia
                ->component('Landing'));
    });
});
