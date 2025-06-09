<?php

declare(strict_types=1);

namespace App\User\Models;

use App\User\Factories\FederatedAccountFactory;
use Carbon\CarbonImmutable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property-read int $id
 * @property-read string $driver
 * @property-read string $external_id
 * @property-read User $user
 * @property-read CarbonImmutable $created_at
 * @property-read CarbonImmutable $updated_at
 */
final class FederatedAccount extends Model
{
    /** @use HasFactory<FederatedAccountFactory> */
    use HasFactory;

    protected static string $factory = FederatedAccountFactory::class;

    /** @return BelongsTo<User, $this> */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
