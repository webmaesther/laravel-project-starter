<?php

declare(strict_types=1);

use Inertia\Testing\AssertableInertia as Inertia;

use function Pest\Laravel\get;

describe('Home page', function (): void {
    test('returns a successful response', function (): void {
        // Act & Assert
        get(route('home'))
            ->assertOk();
    });

    test('shows the home page', function (): void {
        // Act & Assert
        get(route('home'))
            ->assertInertia(fn (Inertia $inertia): Inertia => $inertia->component('Home'));
    });
});
