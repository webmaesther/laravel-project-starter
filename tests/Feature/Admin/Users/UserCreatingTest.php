<?php

declare(strict_types=1);

use App\Filament\Resources\Users\Pages\CreateUser;
use App\Filament\Resources\Users\Schemas\UserForm;
use App\Filament\Resources\Users\UserResource;
use App\Models\User;
use App\Policies\UserPolicy;
use App\States\AdminUser;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Fieldset;
use Filament\Schemas\Components\Tabs\Tab;
use Filament\Support\Icons\Heroicon;

use function Pest\Laravel\actingAs;
use function Pest\Laravel\assertDatabaseCount;
use function Pest\Laravel\assertDatabaseHas;
use function Pest\Laravel\freezeTime;
use function Pest\Livewire\livewire;

covers(UserResource::class);
covers(UserForm::class);

covers(CreateUser::class);

covers(UserPolicy::class);

covers(AdminUser::class);

describe('User Creating', function (): void {
    beforeEach(function (): void {
        actingAs(User::factory()->create(new AdminUser()));
    });

    test('page loads', function (): void {
        livewire(CreateUser::class)
            ->assertOk()
            ->assertSee('Autofill')
            ->assertSee('Create')
            ->assertSee('Create & create another')
            ->assertSee('Cancel');
    });

    test('guest are not allowed to create users', function (): void {
        asGuest();
        livewire(CreateUser::class)
            ->assertForbidden();
    });

    test('creates a user', function (): void {
        livewire(CreateUser::class)
            ->fillForm($user = [
                'name' => fake()->name(),
                'email' => fake()->freeEmail(),
            ])
            ->runAction('create')
            ->assertHasNoFormErrors();

        assertDatabaseHas(User::class, $user);
    });

    test('creates a user using autofill', function (): void {
        assertDatabaseCount(User::class, 1);

        livewire(CreateUser::class)
            ->runAction('autofill')
            ->runAction('create')
            ->assertHasNoFormErrors();

        assertDatabaseCount(User::class, 2);
    });

    test('has the email verified at', function (): void {
        expect(UserForm::configure(Filament\Schemas\Schema::make())->getColumns())
            ->toEqual([
                'lg' => 1,
            ]);

        freezeTime(function (): void {
            livewire(CreateUser::class)
                ->assertFormExists()
                ->assertSchemaComponentExists('personal-info', checkComponentUsing: fn (Tab $t): true => true)
                ->assertSchemaComponentExists(
                    key: 'personal-info.details',
                    checkComponentUsing: fn (Fieldset $fieldset): bool => $fieldset->getColumnSpan() === ['default' => 'full']
                )->assertFormFieldExists(
                    key: 'personal-info.details.name',
                    checkFieldUsing: fn (TextInput $field): bool => $field->getColumnSpan() === ['default' => 'full']
                        && $field->getLabel() === 'Name'
                        && $field->isRequired()
                        && $field->getMaxLength() === 255
                )->assertSchemaComponentExists(
                    key: 'personal-info.email',
                    checkComponentUsing: fn (Fieldset $fieldset): bool => $fieldset->getColumnSpan() === ['default' => 'full']
                )->assertFormFieldExists(
                    key: 'personal-info.email.address',
                    checkFieldUsing: fn (TextInput $field): bool => $field->getLabel() === 'Address'
                        && $field->getPrefixIcon() === Heroicon::AtSymbol
                        && $field->isRequired()
                        && $field->isEmail()
                        && $field->getMaxLength() === 255
                )->assertFormFieldExists(
                    key: 'personal-info.email.verified-at',
                    checkFieldUsing: fn (DateTimePicker $field): bool => $field->getLabel() === 'Verified since'
                        && $field->getPrefixIcon() === Heroicon::Calendar
                        && $field->isReadOnly()
                )->assertSchemaComponentExists(
                    key: 'authentication',
                    checkComponentUsing: fn (Tab $tab): bool => $tab->getLabel() === 'Authentication'
                        && $tab->getBadge() === '!'
                        && $tab->getBadgeTooltip() === 'Change only if you know what you are doing!'
                        && $tab->getBadgeColor() === 'danger'
                        && $tab->getBadgeIcon() === Heroicon::ExclamationTriangle
                )->assertSchemaComponentExists('authentication.credentials', checkComponentUsing: fn (Fieldset $f): true => true)
                ->assertFormFieldExists(
                    key: 'authentication.credentials.password',
                    checkFieldUsing: fn (TextInput $field): bool => $field->isPassword()
                        && $field->getLabel() === 'Password'
                        && $field->isPasswordRevealable()
                        && $field->getMaxLength() === 255
                        && $field->getHint() === 'Danger zone!'
                        && $field->getHintColor() === 'danger'
                        && $field->getHintIcon() === Heroicon::ExclamationTriangle
                        && $field->getHintIconTooltip() === 'Change only if you know what you are doing!'
                )->assertFormFieldExists(
                    key: 'authentication.credentials.password',
                    checkFieldUsing: fn (TextInput $field): bool => $field->isPassword()
                        && $field->getLabel() === 'Password'
                        && $field->isPasswordRevealable()
                        && $field->getMaxLength() === 255
                        && $field->getHint() === 'Danger zone!'
                        && $field->getHintColor() === 'danger'
                        && $field->getHintIcon() === Heroicon::ExclamationTriangle
                        && $field->getHintIconTooltip() === 'Change only if you know what you are doing!'
                )->assertFormFieldExists(
                    key: 'authentication.credentials.password-confirmation',
                    checkFieldUsing: fn (TextInput $field): bool => $field->isPassword()
                        && in_array('required_with:data.password', $field->getValidationRules())
                        && in_array('same:data.password', $field->getValidationRules())
                        && $field->getLabel() === 'Confirm password'
                        && $field->isPasswordRevealable()
                        && $field->getMaxLength() === 255
                        && ! $field->isDehydrated()
                )->assertSchemaComponentExists('authentication.2fa', checkComponentUsing: fn (Fieldset $f): true => true)
                ->assertFormFieldExists(
                    key: 'authentication.2fa.secret',
                    checkFieldUsing: fn (Textarea $field): bool => $field->getLabel() === 'Secret'
                        && $field->getColumnSpan() === ['default' => 'full']
                        && $field->getHint() === 'Danger zone!'
                        && $field->getHintColor() === 'danger'
                        && $field->getHintIcon() === Heroicon::ExclamationTriangle
                        && $field->getHintIconTooltip() === 'Change only if you know what you are doing!'
                )
                ->assertFormFieldExists(
                    key: 'authentication.2fa.recovery-codes',
                    checkFieldUsing: fn (Textarea $field): bool => $field->getLabel() === 'Recovery codes'
                        && $field->getHint() === 'Danger zone!'
                        && $field->getHintColor() === 'danger'
                        && $field->getHintIcon() === Heroicon::ExclamationTriangle
                        && $field->getHintIconTooltip() === 'Change only if you know what you are doing!'
                )
                ->assertFormFieldExists(
                    key: 'authentication.2fa.confirmed-at',
                    checkFieldUsing: fn (DateTimePicker $field): bool => $field->getLabel() === 'Confirmed since'
                        && $field->getPrefixIcon() === Heroicon::Calendar
                        && $field->getHint() === 'Danger zone!'
                        && $field->getHintColor() === 'danger'
                        && $field->getHintIcon() === Heroicon::ExclamationTriangle
                        && $field->getHintIconTooltip() === 'Change only if you know what you are doing!'
                );
        });
    });
});
