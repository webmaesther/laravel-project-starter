<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use InvalidArgumentException;

/**
 * @extends Factory<User>
 */
final class UserFactory extends Factory
{
    public const string DEFAULT_PASSWORD = 'password';

    protected $model = User::class;

    /**
     * Define the model's default state.
     *
     * @return array<model-property<User>, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'email' => function (array $attributes) {
                if (! is_string($attributes['name'] ?? null)) {
                    throw new InvalidArgumentException();
                }

                return str($attributes['name'])
                    ->slug('.')
                    ->append('@')
                    ->append(fake()->freeEmailDomain())
                    ->toString();
            },
            'password' => self::DEFAULT_PASSWORD,
        ];
    }

    public function admin(): self
    {
        return $this->state([
            'email' => 'eszter.czotter@gmail.com',
        ]);
    }

    public function unverified(): self
    {
        return $this->state([
            'email_verified_at' => null,
        ]);
    }

    public function verified(): self
    {
        return $this->state([
            'email_verified_at' => fake()->dateTimeBetween('-3 months'),
        ]);
    }
}
