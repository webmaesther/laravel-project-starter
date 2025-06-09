<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\User\Models\User;
use Illuminate\Database\Seeder;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

final class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Eszter Czotter',
            'email' => 'eszter.czotter@gmail.com',
        ]);
    }
}
