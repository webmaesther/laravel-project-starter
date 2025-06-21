<?php

declare(strict_types=1);

use App\Filament\Resources\Users\Pages\EditUser;
use App\Filament\Resources\Users\Schemas\UserForm;
use App\Filament\Resources\Users\UserResource;
use App\Models\User;
use App\Policies\UserPolicy;
use Filament\Actions\Action;
use Illuminate\Auth\Notifications\VerifyEmail;

use function Pest\Laravel\actingAs;
use function Pest\Laravel\assertDatabaseHas;
use function Pest\Laravel\freezeTime;
use function Pest\Livewire\livewire;

covers(UserResource::class);
covers(UserForm::class);

covers(EditUser::class);

covers(UserPolicy::class);

describe('User Editing', function (): void {

    beforeEach(function (): void {
        actingAs(User::factory()->admin()->create());
    });

    test('page loads', function (): void {
        $user = User::factory()->create();

        livewire(EditUser::class, ['record' => $user->getRouteKey()])
            ->assertOk()
            ->assertSchemaStateSet([
                'name' => $user->name,
                'email' => $user->email,
            ]);
    });

    test('edits a user', function (): void {
        $user = User::factory()->create();

        livewire(EditUser::class, ['record' => $user->getRouteKey()])
            ->fillForm($updatedUser = [
                'name' => fake()->name(),
                'email' => fake()->freeEmail(),
            ])
            ->call('save');

        assertDatabaseHas(User::class, $updatedUser);
    });

    test('guest are not allowed to edit users', function (): void {
        $user = User::factory()->create();

        asGuest();
        livewire(EditUser::class, ['record' => $user->getRouteKey()])
            ->assertForbidden();

    });

    test('enables viewing a user', function (): void {
        $user = User::factory()->create();

        livewire(EditUser::class, ['record' => $user->getRouteKey()])
            ->assertActionEnabled('view');
    });

    test('deletes a user', function (): void {
        $user = User::factory()->create();

        livewire(EditUser::class, ['record' => $user->getRouteKey()])
            ->callAction('delete');

        expect($user->fresh())->toBeNull();
    });

    test('disables sending verification email when email is verified', function (): void {
        $user = User::factory()->verified()->create();

        livewire(EditUser::class, ['record' => $user->getRouteKey()])
            ->assertActionHidden('send_verification_email');
    });

    test('enables sending verification email when email is unverified', function (): void {
        $user = User::factory()->unverified()->create();

        livewire(EditUser::class, ['record' => $user->getRouteKey()])
            ->assertActionExists('send_verification_email', fn (Action $action): bool => $action->getLabel() === 'Send Verification Email'
                && $action->getColor() === 'success')
            ->assertActionVisible('send_verification_email')
            ->assertActionEnabled('send_verification_email');
    });

    test('sends verification email', function (): void {
        Notification::fake();
        $user = User::factory()->unverified()->create();

        livewire(EditUser::class, ['record' => $user->getRouteKey()])
            ->callAction('send_verification_email')
            ->assertNotified("The email verification notification has been sent to <b>{$user->name}</b>.");

        Notification::assertSentTo($user, VerifyEmail::class);
    });

    test('disables marking email verified when email is verified', function (): void {
        $user = User::factory()->verified()->create();

        livewire(EditUser::class, ['record' => $user->getRouteKey()])
            ->assertActionHidden('mark_email_verified');
    });

    test('enables marking email verified when email is unverified', function (): void {
        $user = User::factory()->unverified()->create();

        livewire(EditUser::class, ['record' => $user->getRouteKey()])
            ->assertActionExists('mark_email_verified', fn (Action $action): bool => $action->getLabel() === 'Mark Email Verified'
                && $action->getColor() === 'success')
            ->assertActionVisible('mark_email_verified')
            ->assertActionEnabled('mark_email_verified');
    });

    test('marks the email verified', function (): void {
        freezeTime(function (): void {
            $user = User::factory()->unverified()->create();

            livewire(EditUser::class, ['record' => $user->getRouteKey()])
                ->callAction('mark_email_verified')
                ->assertSchemaStateSet([
                    'email_verified_at' => now(),
                ])
                ->assertNotified("The email <i>{$user->email}</i> is now <u>verified</u> for {$user->name}.");
            expect($user->fresh()->hasVerifiedEmail())->toBeTrue();
        });
    });

    test('disables marking email unverified when email is unverified', function (): void {
        $user = User::factory()->unverified()->create();

        livewire(EditUser::class, ['record' => $user->getRouteKey()])
            ->assertActionHidden('mark_email_unverified');
    });

    test('enables marking email unverified when email is verified', function (): void {
        $user = User::factory()->verified()->create();

        livewire(EditUser::class, ['record' => $user->getRouteKey()])
            ->assertActionExists('mark_email_unverified', fn (Action $action): bool => $action->getLabel() === 'Mark Email Unverified'
                && $action->getColor() === 'danger')
            ->assertActionVisible('mark_email_unverified')
            ->assertActionEnabled('mark_email_unverified');
    });

    test('marks the email unverified', function (): void {
        $user = User::factory()->verified()->create();

        livewire(EditUser::class, ['record' => $user->getRouteKey()])
            ->callAction('mark_email_unverified')
            ->assertSchemaStateSet([
                'email_verified_at' => null,
            ])
            ->assertNotified("The email <i>{$user->email}</i> is now <u>unverified</u> for {$user->name}.");
        expect($user->fresh()->hasVerifiedEmail())->toBeFalse();
    });

});
