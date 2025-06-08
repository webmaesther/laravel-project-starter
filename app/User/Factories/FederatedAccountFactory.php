<?php

declare(strict_types=1);

namespace App\User\Factories;

use App\Models\User;
use App\User\Enums\SocialiteDriver;
use App\User\Models\FederatedAccount;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<FederatedAccount>
 */
final class FederatedAccountFactory extends Factory
{
    protected $model = FederatedAccount::class;

    /**
     * Define the model's default state.
     *
     * @return array<model-property<FederatedAccount>, mixed>
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
