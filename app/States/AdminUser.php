<?php

declare(strict_types=1);

namespace App\States;

use App\Models\User;

final readonly class AdminUser
{
    public const string NAME = 'Eszter Czotter';

    public const string EMAIL = 'eszter.czotter@gmail.com';

    public const string PASSWORD = 'password';

    /**
     * @return array<model-property<User>,mixed>
     */
    public function __invoke(): array
    {
        return [
            'name' => self::NAME,
            'email' => self::EMAIL,
            'password' => self::PASSWORD,
        ];
    }
}
