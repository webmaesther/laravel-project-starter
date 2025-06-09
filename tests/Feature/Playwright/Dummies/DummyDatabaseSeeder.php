<?php

declare(strict_types=1);

namespace Tests\Feature\Playwright\Dummies;

use App\User\Models\User;
use Illuminate\Database\Seeder;

final class DummyDatabaseSeeder extends Seeder
{
    public static array $user = [
        'name' => 'Command Tester',
        'email' => 'command@tester.com',
    ];

    public function run(): void
    {
        User::factory()->create(self::$user);
    }
}
