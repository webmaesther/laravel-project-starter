<?php

declare(strict_types=1);

namespace App\Playwright\Http\Controllers\Api;

use Closure;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Validation\Rule;

final class CommandsController
{
    public function store(Request $request): JsonResponse
    {
        $request->validate([
            'command' => ['required', 'string', Rule::in(array_keys(Artisan::all()))],
            'parameters' => ['bail', 'array', function (string $attribute, array $value, Closure $fail): void {
                if (array_is_list($value)) {
                    $fail("The {$attribute} field must be an array with keys.");
                }
            }],
        ], [
            'in' => 'The :attribute field must be an existing artisan command.',
        ]);

        $exitCode = Artisan::call(
            $request->string('command')->value(),
            $request->array('parameters')
        );

        $success = $exitCode === 0;

        return response()->json([
            'success' => $success,
        ], $success ? 200 : 422);
    }
}
