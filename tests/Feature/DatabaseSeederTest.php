<?php

declare(strict_types=1);

use App\Models\User;
use App\States\AdminUser;

use function Pest\Laravel\assertAuthenticatedAs;
use function Pest\Laravel\assertDatabaseCount;
use function Pest\Laravel\assertDatabaseEmpty;
use function Pest\Laravel\assertDatabaseHas;
use function Pest\Laravel\post;

covers(AdminUser::class);

describe('DatabaseSeeder', function (): void {
    test('creates the admin user', function (): void {
        // Arrange
        assertDatabaseEmpty(User::class);

        // Act
        Artisan::call('db:seed');

        // Assert
        assertDatabaseCount(User::class, 1);
        assertDatabaseHas(User::class, [
            'name' => AdminUser::NAME,
            'email' => AdminUser::EMAIL,
        ]);
    });

    test('after seeding the admin user can log in', function (): void {
        // Arrange
        Artisan::call('db:seed');

        // Act
        post(route('login.store'), [
            'email' => AdminUser::EMAIL,
            'password' => AdminUser::PASSWORD,
        ])->assertRedirect();

        // Assert
        assertAuthenticatedAs(
            User::query()->whereEmail(AdminUser::EMAIL)->firstOrFail()
        );
    });
});
