<?php

declare(strict_types=1);

namespace App\Filament\Resources\Users\Tables;

use App\Models\User;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Notifications\Notification;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Table;

final class UsersTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->searchable(),
                TextColumn::make('email')
                    ->searchable(),
                IconColumn::make('has_enabled_two_factor')
                    ->label('Enabled 2FA')
                    ->boolean()
                    ->state(fn (User $user) => $user->hasEnabledTwoFactorAuthentication()),
                ToggleColumn::make('has_verified_email')
                    ->label('Verified email')
                    ->state(fn (User $user) => $user->hasVerifiedEmail())
                    ->updateStateUsing(function (bool $state, User $user): void {
                        if ($state) {
                            $user->markEmailAsVerified();
                        } else {
                            $user->update(['email_verified_at' => null]);
                        }
                    })->afterStateUpdated(function (bool $state, User $user): void {
                        Notification::make()
                            ->title(function () use ($state, $user): string {
                                $verdict = $state ? '<u>verified</u>' : '<u>unverified</u>';

                                return "The email <i>{$user->getEmailForVerification()}</i> is now {$verdict} for {$user->name}.";
                            })
                            ->success()
                            ->send();
                    }),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                ViewAction::make(),
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
