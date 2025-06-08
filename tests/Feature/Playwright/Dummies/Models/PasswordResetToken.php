<?php

declare(strict_types=1);

namespace Tests\Feature\Playwright\Dummies\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Tests\Feature\Playwright\Dummies\PasswordResetTokenFactory;

final class PasswordResetToken extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected static string $factory = PasswordResetTokenFactory::class;
}
