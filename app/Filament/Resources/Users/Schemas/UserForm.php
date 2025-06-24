<?php

declare(strict_types=1);

namespace App\Filament\Resources\Users\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Fieldset;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;

final class UserForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(1)
            ->components([
                Tabs::make()
                    ->tabs([
                        Tabs\Tab::make('Personal Info')
                            ->key('personal-info')
                            ->schema([
                                Fieldset::make('Details')
                                    ->key('details')
                                    ->columnSpanFull()
                                    ->schema([
                                        TextInput::make('name')
                                            ->key('name')
                                            ->label('Name')
                                            ->columnSpanFull()
                                            ->required()
                                            ->maxLength(255),
                                    ]),
                                Fieldset::make('Email')
                                    ->key('email')
                                    ->columnSpanFull()
                                    ->schema([
                                        TextInput::make('email')
                                            ->key('address')
                                            ->label('Address')
                                            ->prefixIcon(Heroicon::AtSymbol)
                                            ->maxLength(255)
                                            ->email()
                                            ->required(),
                                        DateTimePicker::make('email_verified_at')
                                            ->key('verified-at')
                                            ->label('Verified since')
                                            ->prefixIcon(Heroicon::Calendar)
                                            ->readOnly(),
                                    ]),
                            ]),
                        Tabs\Tab::make('Authentication')
                            ->key('authentication')
                            ->badge('!')
                            ->badgeTooltip('Change only if you know what you are doing!')
                            ->badgeColor('danger')
                            ->badgeIcon(Heroicon::ExclamationTriangle)
                            ->schema([
                                Fieldset::make('Credentials')
                                    ->key('credentials')
                                    ->schema([
                                        TextInput::make('password')
                                            ->key('password')
                                            ->password()
                                            ->revealable()
                                            ->maxLength(255)
                                            ->hint('Danger zone!')
                                            ->hintColor('danger')
                                            ->hintIcon(Heroicon::ExclamationTriangle)
                                            ->hintIconTooltip('Change only if you know what you are doing!'),
                                        TextInput::make('password_confirmation')
                                            ->key('password-confirmation')
                                            ->label('Confirm password')
                                            ->password()
                                            ->requiredWith('password')
                                            ->revealable()
                                            ->maxLength(255)
                                            ->same('password')
                                            ->dehydrated(false),
                                    ]),
                                Fieldset::make('Two-factor (2FA)')
                                    ->key('2fa')
                                    ->schema([
                                        Textarea::make('two_factor_secret')
                                            ->key('secret')
                                            ->label('Secret')
                                            ->hint('Danger zone!')
                                            ->hintColor('danger')
                                            ->hintIcon(Heroicon::ExclamationTriangle)
                                            ->hintIconTooltip('Change only if you know what you are doing!')
                                            ->columnSpanFull(),
                                        Textarea::make('two_factor_recovery_codes')
                                            ->key('recovery-codes')
                                            ->label('Recovery codes')
                                            ->hint('Danger zone!')
                                            ->hintColor('danger')
                                            ->hintIcon(Heroicon::ExclamationTriangle)
                                            ->hintIconTooltip('Change only if you know what you are doing!'),
                                        DateTimePicker::make('two_factor_confirmed_at')
                                            ->key('confirmed-at')
                                            ->label('Confirmed since')
                                            ->prefixIcon(Heroicon::Calendar)
                                            ->hint('Danger zone!')
                                            ->hintColor('danger')
                                            ->hintIcon(Heroicon::ExclamationTriangle)
                                            ->hintIconTooltip('Change only if you know what you are doing!'),
                                    ]),
                            ]),
                    ]),
            ]);
    }
}
