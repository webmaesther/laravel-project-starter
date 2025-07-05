<?php

declare(strict_types=1);

namespace App\States;

use App\Models\User;

final readonly class DefaultPasswordUser
{
    public const string PASSWORD = 'password';

    /**
     * @return array<model-property<User>,mixed>
     */
    public function __invoke(): array
    {
        return [
            'password' => self::PASSWORD,
        ];
    }
}
