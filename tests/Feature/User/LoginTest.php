<?php

declare(strict_types=1);

use App\Http\Controllers\LoginLinkController;
use App\Models\User;
use App\Notifications\MagicLink;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;

use function Pest\Laravel\assertAuthenticatedAs;
use function Pest\Laravel\assertGuest;
use function Pest\Laravel\freezeTime;
use function Pest\Laravel\get;
use function Pest\Laravel\post;
use function Pest\Laravel\travel;

covers([
    MagicLink::class,
    LoginLinkController::class,
]);

describe('Login', function (): void {
    test('users can log in with their email and password', function (): void {
        $user = User::factory()->create([
            'password' => User::DEFAULT_PASSWORD,
        ]);

        post(route('login.store'), [
            'email' => $user->email,
            'password' => User::DEFAULT_PASSWORD,
        ])->assertRedirectToRoute('dashboard')
            ->assertSessionHasNoErrors();

        assertAuthenticatedAs($user);
    });

    test('users can request a magic link with their email address', function (): void {
        Notification::fake();
        $user = User::factory()->create();

        post(route('login.link.store'), [
            'email' => $user->email,
        ])->assertRedirectBack()
            ->assertSessionHasNoErrors()
            ->assertSessionHas([
                'toast' => 'Magic link sent. Please check your email.',
            ]);

        assertGuest();
        Notification::assertSentTo($user, MagicLink::class, function (MagicLink $email) use ($user): bool {
            $request = Request::create($email->url);
            $url = mb_rtrim($request->fullUrlWithQuery([
                'signature' => null,
                'expires' => null,
            ]), '?');

            return $user->is($email->user)
                && $request->hasValidSignature()
                && $url === route('login.link.show', ['user' => $user->id]);
        });
    });

    test('users can log in with the magic link they received', function (): void {
        $user = User::factory()->create([
            'password' => null,
        ]);

        get(URL::temporarySignedRoute('login.link.show', now()->addMinutes(15), ['user' => $user->id]))
            ->assertRedirectToRoute('dashboard')
            ->assertSessionHasNoErrors();

        assertAuthenticatedAs($user);
    });

    test('magic links are temporary', function (): void {
        Notification::fake();
        freezeTime(function (): void {
            $user = User::factory()->create();

            post(route('login.link.store'), [
                'email' => $user->email,
            ])->assertRedirectBack();

            Notification::assertSentTo($user, MagicLink::class, function (MagicLink $email): bool {
                $request = Request::create($email->url);

                travel(15)->minutes();

                $validBefore = $request->hasValidSignature();

                travel(1)->second();

                return $validBefore && ! $request->hasValidSignature();
            });
        });
    });

    test('magic links require a valid signature', function (): void {
        $user = User::factory()->create([
            'password' => null,
        ]);

        get(route('login.link.show', ['user' => $user]))
            ->assertForbidden();
    });
});
