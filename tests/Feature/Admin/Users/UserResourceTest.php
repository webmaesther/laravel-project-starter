<?php

declare(strict_types=1);

use App\Filament\Resources\Users\UserResource;
use App\Models\User;
use Filament\Resources\Pages\PageRegistration;

covers(UserResource::class);

describe('User Resource', function (): void {

    test('finds users globally by attributes', function (string $attribute): void {
        expect(UserResource::getGloballySearchableAttributes())
            ->toContain($attribute);
    })->with(['name', 'email']);

    test('titles users globally by name', function (): void {
        expect(UserResource::getRecordTitleAttribute())->toBe('name');
    });

    test('details users globally by email', function (): void {
        $user = User::factory()->create();

        expect(UserResource::getGlobalSearchResultDetails($user))
            ->toContain($user->email);
    });

    test('has all the pages', function (): void {
        expect(UserResource::getPages())
            ->toHaveKeys(['index', 'create', 'view', 'edit'])
            ->each->toBeInstanceOf(PageRegistration::class);
    });

});
