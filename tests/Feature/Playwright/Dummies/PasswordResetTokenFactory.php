<?php

declare(strict_types=1);

namespace Tests\Feature\Playwright\Dummies;

use Illuminate\Database\Eloquent\Factories\Factory;
use Override;
use Tests\Feature\Playwright\Dummies\Models\PasswordResetToken;

final class PasswordResetTokenFactory extends Factory
{
    protected $model = PasswordResetToken::class;

    /**
     * @return array<string, mixed>
     */
    #[Override]
    public function definition(): array
    {
        return [
            'email' => fake()->email(),
            'token' => fake()->word(),
            'created_at' => fake()->dateTimeBetween('-1 hour'),
        ];
    }
}
