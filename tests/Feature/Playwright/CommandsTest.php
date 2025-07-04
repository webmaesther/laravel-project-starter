<?php

declare(strict_types=1);

use App\Http\Controllers\Api\CommandsController;
use App\Http\Middleware\ForceJsonResponse;
use App\Http\Middleware\UnlessProduction;
use App\Models\User;
use Illuminate\Support\Facades\Artisan;
use Tests\Feature\Playwright\Dummies\Console\Commands\ErrorCommand;
use Tests\Feature\Playwright\Dummies\DummyDatabaseSeeder;

use function Pest\Laravel\assertDatabaseCount;
use function Pest\Laravel\assertDatabaseEmpty;
use function Pest\Laravel\assertDatabaseHas;
use function Pest\Laravel\get;
use function Pest\Laravel\post;

covers([
    CommandsController::class,
    ForceJsonResponse::class,
    UnlessProduction::class,
]);

describe('Commands', function (): void {

    test('it returns 404 on production', function (): void {
        app()->bind('env', fn (): string => 'production');
        expect(app()->isProduction())->toBeTrue();

        $response = post(route('api.playwright.commands.store'));

        $response->assertNotFound()
            ->assertJson(['message' => 'Not Found']);
    });

    test('validates the command as required', function (): void {
        $response = post(route('api.playwright.commands.store'));

        $response->assertUnprocessable()
            ->assertJsonValidationErrors([
                'command' => 'The command field is required.',
            ]);
    });

    test('validates the command to be string', function (): void {
        $response = post(route('api.playwright.commands.store'), [
            'command' => 123,
        ]);

        $response->assertUnprocessable()
            ->assertJsonValidationErrors([
                'command' => 'The command field must be a string.',
            ]);
    });

    test('validates the command to be an existing artisan command', function (): void {
        $response = post(route('api.playwright.commands.store'), [
            'command' => 'missing-command',
        ]);

        $response->assertUnprocessable()
            ->assertJsonValidationErrors([
                'command' => 'The command field must be an existing artisan command.',
            ]);
    });

    test('runs the artisan db:seed command', function (): void {
        assertDatabaseEmpty(User::class);

        $response = post(route('api.playwright.commands.store'), [
            'command' => 'db:seed',
        ]);

        $response->assertOk()
            ->assertExactJson(['success' => true]);
        assertDatabaseCount(User::class, 1);
    });

    test('runs the artisan down command', function (): void {
        expect(app()->isDownForMaintenance())->toBeFalse();

        $response = post(route('api.playwright.commands.store'), [
            'command' => 'down',
        ]);

        $response->assertOk()
            ->assertExactJson(['success' => true]);

        expect(app()->isDownForMaintenance())->toBeTrue();
    });

    test('validates the parameters to be an array', function (): void {
        $response = post(route('api.playwright.commands.store'), [
            'command' => 'string',
            'parameters' => 'not-an-array',
        ]);

        $response->assertUnprocessable()
            ->assertJsonValidationErrors([
                'parameters' => 'The parameters field must be an array.',
            ]);
    });

    test('validates the parameters to be an array with keys', function (): void {
        $response = post(route('api.playwright.commands.store'), [
            'command' => 'string',
            'parameters' => ['array', 'without', 'keys'],
        ]);

        $response->assertUnprocessable()
            ->assertJsonValidationErrors([
                'parameters' => 'The parameters field must be an array with keys.',
            ]);
    });

    test('runs the artisan db:seed command with the class argument', function (): void {
        assertDatabaseEmpty(User::class);

        $response = post(route('api.playwright.commands.store'), [
            'command' => 'db:seed',
            'parameters' => [
                'class' => DummyDatabaseSeeder::class,
            ],
        ]);

        $response->assertOk()
            ->assertExactJson(['success' => true]);
        assertDatabaseCount(User::class, 1);
        assertDatabaseHas(User::class, DummyDatabaseSeeder::$user);
    });

    test('runs the artisan down command with the status option', function (): void {
        expect(app()->isDownForMaintenance())->toBeFalse();

        $response = post(route('api.playwright.commands.store'), [
            'command' => 'down',
            'parameters' => [
                '--status' => 500,
            ],
        ]);

        $response->assertOk()
            ->assertExactJson(['success' => true]);

        expect(app()->isDownForMaintenance())->toBeTrue();
        get('/')->assertInternalServerError();
    });

    test('returns success false when the artisan command failed', function (): void {
        Artisan::registerCommand(new ErrorCommand());

        $response = post(route('api.playwright.commands.store'), [
            'command' => 'error',
        ]);

        $response->assertUnprocessable()
            ->assertExactJson(['success' => false]);
    });

});
