<?php

declare(strict_types=1);

use App\Http\Middleware\ForceJsonResponse;
use App\Http\Middleware\UnlessProduction;
use App\Models\User;
use App\Playwright\Http\Controllers\Api\FactoriesController;
use Tests\Feature\Playwright\Dummies\Models\Feature;
use Tests\Feature\Playwright\Dummies\Models\Fruit;
use Tests\Feature\Playwright\Dummies\Models\PasswordResetToken;
use Tests\Feature\Playwright\Dummies\Models\Subscription;

use function Pest\Laravel\assertDatabaseCount;
use function Pest\Laravel\assertDatabaseEmpty;
use function Pest\Laravel\assertDatabaseHas;
use function Pest\Laravel\post;

covers([
    FactoriesController::class,
    ForceJsonResponse::class,
    UnlessProduction::class,
    App\Http\Resources\User::class,
]);

describe('Factories', function (): void {

    test('it returns 404 on production', function (): void {
        app()->bind('env', fn (): string => 'production');
        expect(app()->isProduction())->toBeTrue();

        $response = post(route('api.playwright.factories.store'));

        $response->assertNotFound()
            ->assertJson(['message' => 'Not Found']);
    });

    test('validates the model field as required', function (): void {
        $response = post(route('api.playwright.factories.store'));

        $response->assertUnprocessable()
            ->assertJsonValidationErrors([
                'model' => 'The model field is required.',
            ]);
    });

    test('validates the model field to be a string', function (): void {
        $response = post(route('api.playwright.factories.store'), [
            'model' => 123,
        ]);

        $response->assertUnprocessable()
            ->assertJsonValidationErrors([
                'model' => 'The model field must be a string.',
            ]);
    });

    test('validates the model field to be an eloquent model', function (): void {
        $response = post(route('api.playwright.factories.store'), [
            'model' => Fruit::class,
        ]);

        $response->assertUnprocessable()
            ->assertJsonValidationErrors([
                'model' => 'This class is not an eloquent model.',
            ]);
    });

    test('validates the model field to have a factory', function (): void {
        assertDatabaseEmpty(Feature::class);

        $response = post(route('api.playwright.factories.store'), [
            'model' => Feature::class,
        ]);

        $response->assertUnprocessable()
            ->assertJsonValidationErrors([
                'model' => 'This model does not have a factory.',
            ]);
        assertDatabaseEmpty(Feature::class);
    });

    test('validates the model field factory to be an eloquent factory', function (): void {
        assertDatabaseEmpty(Subscription::class);

        $response = post(route('api.playwright.factories.store'), [
            'model' => Subscription::class,
        ]);

        $response->assertUnprocessable()
            ->assertJsonValidationErrors([
                'model' => 'The factory of this model is not an eloquent factory.',
            ]);
    });

    test('creates a new instance of a model with a factory', function (string $model, array $structure): void {
        assertDatabaseEmpty($model);

        $response = post(route('api.playwright.factories.store'), [
            'model' => $model,
        ]);

        $response->assertCreated()
            ->assertJsonStructure([
                'data' => [
                    '*' => $structure,
                ],
            ]);
        assertDatabaseCount($model, 1);
    })->with([
        ['model' => User::class, 'structure' => ['id', 'name', 'email']],
        ['model' => PasswordResetToken::class,  'structure' => ['id', 'email', 'token']],
    ]);

    test('validates the state to be an array', function (): void {
        $response = post(route('api.playwright.factories.store'), [
            'model' => 'string',
            'state' => 'not-an-array',
        ]);

        $response->assertUnprocessable()
            ->assertJsonValidationErrors([
                'state' => 'The state field must be an array.',
            ]);
    });

    test('validates the state to be an array with keys', function (): void {
        $response = post(route('api.playwright.factories.store'), [
            'model' => 'string',
            'state' => ['array', 'without', 'keys'],
        ]);

        $response->assertUnprocessable()
            ->assertJsonValidationErrors([
                'state' => 'The state field must be an array with keys.',
            ]);
    });

    test('creates a new instance of the model with the given state', function (string $model, array $state): void {
        assertDatabaseEmpty($model);

        $response = post(route('api.playwright.factories.store'), [
            'model' => $model,
            'state' => $state,
        ]);

        $response->assertCreated()
            ->assertJsonFragment($state);
        assertDatabaseCount($model, 1);
        assertDatabaseHas($model, $state);
    })->with([
        ['model' => User::class, 'state' => ['name' => fake()->name(), 'email' => fake()->email()]],
        ['model' => PasswordResetToken::class, 'state' => ['email' => fake()->email(), 'token' => fake()->uuid()]],
    ]);

    test('validates the count to be a number', function (): void {
        $response = post(route('api.playwright.factories.store'), [
            'model' => 'string',
            'count' => 'not-a-number',
        ]);

        $response->assertUnprocessable()
            ->assertJsonValidationErrors([
                'count' => 'The count field must be a number.',
            ]);
    });

    test('validates the count to be an integer', function (): void {
        $response = post(route('api.playwright.factories.store'), [
            'model' => 'string',
            'count' => 1.23,
        ]);

        $response->assertUnprocessable()
            ->assertJsonValidationErrors([
                'count' => 'The count field must be an integer.',
            ]);
    });

    test('creates multiple instances of a model with a factory', function (string $model): void {
        assertDatabaseEmpty($model);
        $count = fake()->numberBetween(2, 10);

        $response = post(route('api.playwright.factories.store'), [
            'model' => $model,
            'count' => $count,
        ]);

        $response->assertCreated()
            ->assertJsonCount($count, 'data');
        assertDatabaseCount($model, $count);
    })->with([
        ['model' => User::class],
        ['model' => PasswordResetToken::class],
    ]);

});
