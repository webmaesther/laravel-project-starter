<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Enums\SocialiteDriver;
use App\Models\Identity;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Identity>
 */
final class IdentityFactory extends Factory
{
    protected $model = Identity::class;

    /**
     * Define the model's default state.
     *
     * @return array<model-property<Identity>, mixed>
     */
    public function definition(): array
    {
        return [
            'driver' => fake()->randomElement(SocialiteDriver::cases()),
            'external_id' => fake()->uuid(),
            'user_id' => User::factory(),
        ];
    }
}
