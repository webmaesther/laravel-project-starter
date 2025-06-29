<?php

declare(strict_types=1);

use App\Notifications\MagicLink;

covers(MagicLink::class);

describe('Magic Link', function (): void {
    test('magic link content', function (): void {
        $user = App\Models\User::factory()->create();
        config()->set('app.name', $app = fake()->word());

        $email = new MagicLink($user)->toMail();

        expect($email)
            ->subject->toBe('Magic Link')
            ->actionUrl->toContain(route('login.link.show', $user))
            ->actionText->toBe('Magic Link')
            ->introLines->toContain("Welcome back {$user->name}!")
            ->introLines->toContain("Use the following link to login to {$app}.")
            ->outroLines->toContain('Good to see you again!');
    });

    test('magic link data', function (): void {
        $user = App\Models\User::factory()->create();
        config()->set('app.name', $app = fake()->word());

        $data = new MagicLink($user)->toArray();

        expect($data['user_id'])->toBe($user->id)
            ->and($data['user_name'])->toBe($user->name)
            ->and($data['app_name'])->toBe($app)
            ->and($data['url'])->toContain(route('login.link.show', $user));
    });

    test('magic link channels', function (): void {
        $user = App\Models\User::factory()->create();

        $channels = new MagicLink($user)->via();

        expect($channels)->toEqual(['mail']);
    });
});
