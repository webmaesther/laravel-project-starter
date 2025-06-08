<?php

declare(strict_types=1);

namespace App\Playwright\Http\Controllers\Api;

use Closure;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

final class FactoriesController
{
    public function store(Request $request): JsonResponse
    {
        $request->validate([
            'model' => ['required', 'string'],
            'state' => ['bail', 'array', function (string $attribute, array $value, Closure $fail): void {
                if (array_is_list($value)) {
                    $fail("The {$attribute} field must be an array with keys.");
                }
            }],
            'count' => ['numeric', 'integer'],
        ]);

        $model = $request->string('model')->value();

        if (! is_subclass_of($model, Model::class)) {
            throw ValidationException::withMessages([
                'model' => 'This class is not an eloquent model.',
            ]);
        }

        if (! method_exists($model, 'factory')) {
            throw ValidationException::withMessages([
                'model' => 'This model does not have a factory.',
            ]);
        }

        $factory = $model::factory();

        if (! is_subclass_of($factory, Factory::class)) {
            throw ValidationException::withMessages([
                'model' => 'The factory of this model is not an eloquent factory.',
            ]);
        }

        /** @var array<string,mixed> $state */
        $state = $request->array('state');
        $count = $request->integer('count', 1);

        /** @var Factory<Model> $factory */
        $models = $factory
            ->state($state)
            ->count($count)
            ->create();

        /** @var Collection<int, Model> $models */
        return $models
            ->toResourceCollection()
            ->response()
            ->setStatusCode(201);
    }
}
