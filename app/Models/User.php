<?php

declare(strict_types=1);

namespace App\Models;

use App\User\Models\FederatedAccount;
use Database\Factories\UserFactory;
use Illuminate\Auth\MustVerifyEmail as VerifiesEmail;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;

final class User extends Authenticatable implements MustVerifyEmail
{
    /** @use HasFactory<UserFactory> */
    use HasFactory;

    use VerifiesEmail;

    /** @var list<string> */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /** @return HasMany<FederatedAccount, $this> */
    public function federated_accounts(): HasMany
    {
        return $this->hasMany(FederatedAccount::class);
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
