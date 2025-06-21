<?php

declare(strict_types=1);

namespace App\Filament\Resources\Users\Pages;

use App\Filament\Resources\Users\UserResource;
use App\Models\User;
use Filament\Actions\Action;
use Filament\Resources\Pages\CreateRecord;
use Filament\Support\Icons\Heroicon;

final class CreateUser extends CreateRecord
{
    protected static string $resource = UserResource::class;

    public function autofill(): void
    {
        /** @var array<model-property<User>,mixed> $data */
        $data = User::factory()->make()->toArray();
        $this->form->fill([
            ...$data,
            'password' => User::factory()::DEFAULT_PASSWORD,
            'password_confirmation' => User::factory()::DEFAULT_PASSWORD,
        ]);
    }

    protected function getFormActions(): array
    {
        return [
            Action::make('autofill')
                ->icon(Heroicon::OutlinedBolt)
                ->action('autofill'),
            ...parent::getFormActions(),
        ];
    }
}
