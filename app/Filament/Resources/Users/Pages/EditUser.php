<?php

declare(strict_types=1);

namespace App\Filament\Resources\Users\Pages;

use App\Filament\Resources\Users\UserResource;
use App\Models\User;
use Filament\Actions\Action;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\EditRecord;

final class EditUser extends EditRecord
{
    protected static string $resource = UserResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Action::make('send_verification_email')
                ->label('Send Verification Email')
                ->requiresConfirmation()
                ->visible(fn (User $user): bool => ! $user->hasVerifiedEmail())
                ->color('success')
                ->action(function (User $user): void {
                    $user->sendEmailVerificationNotification();
                })->after(function (User $user): void {
                    Notification::make()
                        ->title("The email verification notification has been sent to <b>{$user->name}</b>.")
                        ->success()
                        ->send();
                }),
            Action::make('mark_email_verified')
                ->label('Mark Email Verified')
                ->visible(fn (User $user): bool => ! $user->hasVerifiedEmail())
                ->color('success')
                ->action(function (User $user): void {
                    $user->markEmailAsVerified();

                    $this->refreshFormData([
                        'email_verified_at',
                    ]);
                })->after(function (User $user): void {
                    Notification::make()
                        ->title(fn (): string => "The email <i>{$user->getEmailForVerification()}</i> is now <u>verified</u> for {$user->name}.")
                        ->success()
                        ->send();
                }),
            Action::make('mark_email_unverified')
                ->label('Mark Email Unverified')
                ->requiresConfirmation()
                ->visible(fn (User $user) => $user->hasVerifiedEmail())
                ->color('danger')
                ->action(function (User $user): void {
                    $user->update([
                        'email_verified_at' => null,
                    ]);

                    $this->refreshFormData([
                        'email_verified_at',
                    ]);
                })->after(function (User $user): void {
                    Notification::make()
                        ->title("The email <i>{$user->email}</i> is now <u>unverified</u> for {$user->name}.")
                        ->success()
                        ->send();
                }),
            ViewAction::make(),
            DeleteAction::make(),
        ];
    }
}
