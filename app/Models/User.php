<?php

declare(strict_types=1);

namespace App\Models;

use App\States\AdminUser;
use Database\Factories\UserFactory;
use Filament\Models\Contracts\FilamentUser;
use Filament\Panel;
use Illuminate\Auth\MustVerifyEmail as VerifiesEmail;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Paddle\Billable;

final class User extends Authenticatable implements FilamentUser, MustVerifyEmail
{
    use Billable;

    /** @use HasFactory<UserFactory> */
    use HasFactory;

    use Notifiable;
    use TwoFactorAuthenticatable;
    use VerifiesEmail;

    protected static string $factory = UserFactory::class;

    /** @var list<model-property<User>> */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /** @return HasMany<Identity, $this> */
    public function identities(): HasMany
    {
        return $this->hasMany(Identity::class);
    }

    public function canAccessPanel(Panel $panel): bool
    {
        return $this->can('access', $panel);
    }

    public function isAdmin(): bool
    {
        return $this->email === AdminUser::EMAIL;
    }

    /** @return array<string, string> */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
}
