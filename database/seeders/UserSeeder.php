<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\User;
use App\States\AdminUser;
use Illuminate\Database\Seeder;

final class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::factory()->create(new AdminUser());
    }
}
