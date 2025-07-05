<?php

declare(strict_types=1);

use App\Filament\Resources\Users\Pages\ViewUser;
use App\Filament\Resources\Users\Schemas\UserInfolist;
use App\Filament\Resources\Users\UserResource;
use App\Models\User;
use App\Policies\UserPolicy;
use App\States\AdminUser;

use function Pest\Laravel\actingAs;
use function Pest\Livewire\livewire;

covers(UserResource::class);
covers(UserInfolist::class);

covers(ViewUser::class);

covers(UserPolicy::class);

describe('User Viewing', function (): void {

    beforeEach(function (): void {
        actingAs(User::factory()->create(new AdminUser()));
    });

    it('page loads', function (): void {
        $user = User::factory()->create();

        livewire(ViewUser::class, [
            'record' => $user->getRouteKey(),
        ])
            ->assertOk()
            ->assertSee('Edit')
            ->assertSchemaStateSet([
                'name' => $user->name,
                'email' => $user->email,
            ]);
    });

    test('guest are not allowed to list users', function (): void {

        asGuest();
        $user = User::factory()->create();

        livewire(ViewUser::class, [
            'record' => $user->getRouteKey(),
        ])->assertForbidden();

    });

});
