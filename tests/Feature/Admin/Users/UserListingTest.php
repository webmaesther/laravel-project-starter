<?php

declare(strict_types=1);

use App\Filament\Resources\Users\Pages\ListUsers;
use App\Filament\Resources\Users\Tables\UsersTable;
use App\Filament\Resources\Users\UserResource;
use App\Models\User;
use App\Policies\UserPolicy;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\Testing\TestAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\ToggleColumn;

use function Pest\Laravel\actingAs;
use function Pest\Laravel\assertDatabaseCount;
use function Pest\Livewire\livewire;

covers(UserResource::class);
covers(UsersTable::class);

covers(ListUsers::class);

covers(UserPolicy::class);

describe('User Listing', function (): void {

    beforeEach(function (): void {
        actingAs(User::factory()->admin()->create());
    });

    test('page loads', function (): void {

        livewire(ListUsers::class)
            ->assertOk();

    });

    test('renders the columns', function (string $colum): void {

        livewire(ListUsers::class)
            ->assertCanRenderTableColumn($colum);

    })->with(['name', 'email', 'has_enabled_two_factor', 'has_verified_email']);

    test('shows the table actions', function (string $action): void {

        livewire(ListUsers::class)
            ->assertTableActionExists($action)
            ->assertTableActionEnabled($action);

    })->with([
        ['action' => ViewAction::class],
        ['action' => EditAction::class],
    ]);

    test('deletes in bulk', function (): void {
        $users = User::factory(5)->create();

        assertDatabaseCount(User::class, 6);

        livewire(ListUsers::class)
            ->selectTableRecords($users->pluck('id')->toArray())
            ->callAction(TestAction::make(DeleteBulkAction::class)->table()->bulk());

        assertDatabaseCount(User::class, 1);
    });

    test('toggles email verification', function (bool $state, string $verdict): void {
        $user = User::factory()->create([
            'email_verified_at' => $state ? null : now(),
        ]);

        livewire(ListUsers::class)
            ->assertTableColumnExists('has_verified_email', function (ToggleColumn $column) use ($state): bool {
                $column->updateState($state);

                return $column->getLabel() === 'Verified email';
            }, $user)
            ->assertNotified("The email <i>{$user->getEmailForVerification()}</i> is now {$verdict} for {$user->name}.");

        expect($user->hasVerifiedEmail())->toBe($state);
    })->with([
        ['state' => true, 'verdict' => '<u>verified</u>'],
        ['state' => false, 'verdict' => '<u>unverified</u>'],
    ]);

    test('guest are not allowed to list users', function (): void {

        asGuest();
        livewire(ListUsers::class)
            ->assertForbidden();

    });

    test('lists the users', function (): void {
        $users = User::factory()->count(5)->create();

        livewire(ListUsers::class)
            ->assertSee('New user')
            ->assertCanSeeTableRecords($users)
            ->searchTable($users->first()->name)
            ->assertCanSeeTableRecords($users->take(1))
            ->assertCanNotSeeTableRecords($users->skip(1))
            ->searchTable($users->last()->email)
            ->assertCanSeeTableRecords($users->take(-1))
            ->assertCanNotSeeTableRecords($users->take($users->count() - 1));
    });

});
