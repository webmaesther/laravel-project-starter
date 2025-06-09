<?php

declare(strict_types=1);

use App\User\Factories\FederatedAccountFactory;
use App\User\Factories\UserFactory;
use App\User\Http\Controllers\FederatedLoginController;
use App\User\Http\Middleware\RedirectLocalHost;
use App\User\Models\FederatedAccount;
use App\User\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Uri;
use Laravel\Socialite\Facades\Socialite;
use Laravel\Socialite\Two\User as SocialiteUser;

use function Pest\Laravel\assertAuthenticatedAs;
use function Pest\Laravel\assertDatabaseCount;
use function Pest\Laravel\assertDatabaseHas;
use function Pest\Laravel\get;

covers([
    FederatedLoginController::class,
    FederatedAccount::class,
    FederatedAccountFactory::class,
    RedirectLocalHost::class,
    User::class,
    UserFactory::class,
]);

describe('Federated Accounts', function (): void {

    test('redirects to the federated account provider', function (string $driver): void {
        Socialite::shouldReceive('driver')
            ->with($driver)
            ->once()
            ->andReturn(socialite($driver));

        $response = get(route('federated.redirect', $driver));

        $response->assertRedirect($driver);
    });

    test('creates a user with a federated account', function (string $driver): void {
        FederatedAccount::factory()->create();
        $user = new SocialiteUser()->map([
            'id' => fake()->uuid(),
            'name' => fake()->name(),
            'email' => fake()->email(),
        ]);
        Socialite::shouldReceive('driver')
            ->with($driver)
            ->once()
            ->andReturn(socialite($driver, $user));

        $response = get(route('federated.callback', $driver));

        $response->assertRedirect(route('home'));
        assertDatabaseCount(User::class, 2);
        assertDatabaseHas(User::class, [
            'name' => $user->getName(),
            'email' => $email = $user->getEmail(),
        ]);
        assertDatabaseCount(FederatedAccount::class, 2);
        assertDatabaseHas(FederatedAccount::class, [
            'driver' => $driver,
            'user_id' => User::query()->where('email', $email)->first()->id,
            'external_id' => $user->getId(),
        ]);
        assertAuthenticatedAs(User::query()->where('email', $email)->first());
    });

    test('authenticates a user with a federated account', function (string $driver): void {
        $account = FederatedAccount::factory()->create(['driver' => $driver]);
        $user = new SocialiteUser()->map([
            'id' => $account->external_id,
        ]);
        Socialite::shouldReceive('driver')
            ->with($driver)
            ->once()
            ->andReturn(socialite($driver, $user));

        $response = get(route('federated.callback', $driver));

        $response->assertRedirect(route('home'));
        assertDatabaseCount(User::class, 1);
        assertDatabaseCount(FederatedAccount::class, 1);
        assertAuthenticatedAs($account->user);
    });

    test('creates a federated account for an existing user', function (string $driver): void {
        User::factory()->create([
            'email' => $email = fake()->email(),
        ]);
        $user = new SocialiteUser()->map([
            'id' => fake()->uuid(),
            'email' => $email,
        ]);
        Socialite::shouldReceive('driver')
            ->with($driver)
            ->once()
            ->andReturn(socialite($driver, $user));

        $response = get(route('federated.callback', $driver));

        $response->assertRedirect(route('home'));
        assertDatabaseCount(User::class, 1);
        assertDatabaseCount(FederatedAccount::class, 1);
        assertAuthenticatedAs(User::query()->first());
    });

    test('returns 404 for mistyped federated account driver', function (string $driver, string $route): void {
        $driver .= fake()->randomAscii();

        $response = get(route("federated.{$route}", $driver));

        $response->assertNotFound();

    })->with(['callback', 'redirect']);

    test('redirects the callback with the correct scheme', function (string $driver): void {
        $app = Uri::of(config('app.url'));

        get("{$app->withScheme($app->scheme() === 'https' ? 'http' : 'https')}/{$driver}/callback")
            ->assertPermanentRedirect();
    });

    test('redirects the callback with the correct host', function (string $driver): void {
        $app = Uri::of(config('app.url'));

        get("{$app->withHost(fake()->randomLetter().$app->host())}/{$driver}/callback")
            ->assertPermanentRedirect();
    });

    test('redirects the callback with the correct port', function (string $driver): void {
        $app = Uri::of(config('app.url'));

        get("{$app->withPort($app->port() + 1)}/{$driver}/callback")
            ->assertPermanentRedirect();
    });

    function socialite(string $driver, ?SocialiteUser $user = null): object
    {
        return new readonly class($driver, $user)
        {
            public function __construct(
                private string $driver,
                private ?SocialiteUser $user,
            ) {}

            public function redirect(): RedirectResponse
            {
                return new RedirectResponse($this->driver);
            }

            public function user(): ?SocialiteUser
            {
                return $this->user;
            }
        };
    }

})->with([
    'google',
    'facebook',
    'linkedin-openid',
    'x',
    'slack',
    'github',
    'gitlab',
    'bitbucket',
    'twitch',
]);
