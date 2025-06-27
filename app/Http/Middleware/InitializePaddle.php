<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Symfony\Component\HttpFoundation\Response;

// @codeCoverageIgnoreStart

final class InitializePaddle
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        Inertia::share([
            'paddle' => [
                'token' => config('cashier.client_side_token'),
                'environment' => config('cashier.sandbox') ? 'sandbox' : 'production',
                'checkout' => [
                    'settings' => config('cashier.settings'),
                ],
            ],
        ]);

        return $next($request);
    }
}

// @codeCoverageIgnoreEnd
