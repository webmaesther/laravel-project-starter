<?php

declare(strict_types=1);

use App\Models\User;
use Carbon\CarbonImmutable;
use Database\Factories\UserFactory;
use Illuminate\Support\Facades\Hash;

use function Pest\Laravel\assertDatabaseCount;

covers([
    User::class,
]);

describe('User', function (): void {
    test('fields are unguarded', function (): void {
        User::query()->create([
            'name' => 'Test User',
            'email' => 'test@email.com',
            'password' => 'password',
        ]);

        assertDatabaseCount(User::class, 1);
    });

    test('password and remember token is removed from array data', function (): void {
        UserFactory::new()->create([
            'password' => 'password',
            'remember_token' => 'remember_token',
        ]);

        assertDatabaseCount(User::class, 1);
        expect(User::query()->first()->toArray())
            ->not->toHaveKeys(['password', 'remember_token']);
    });

    test('password is hashed', function (): void {
        $password = fake()->password();

        UserFactory::new()->create([
            'password' => $password,
        ]);

        assertDatabaseCount(User::class, 1);
        expect(Hash::check($password, User::query()->first()->password))
            ->toBeTrue();
    });

    test('email verified at is a datetime', function (): void {
        UserFactory::new()->create([
            'email_verified_at' => fake()->dateTime(),
        ]);

        assertDatabaseCount(User::class, 1);
        expect(User::query()->first()->email_verified_at)
            ->toBeInstanceOf(CarbonImmutable::class);
    });
});
