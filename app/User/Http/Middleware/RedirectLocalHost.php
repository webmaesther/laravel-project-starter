<?php

declare(strict_types=1);

namespace App\User\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Uri;
use Symfony\Component\HttpFoundation\Response;

final class RedirectLocalHost
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $uri = $request->uri();
        $app = Uri::of(config()->string('app.url'));

        if ($uri->host() !== $app->host()
            || $uri->scheme() !== $app->scheme()
            || $uri->port() !== $app->port()) {

            return redirect($request->uri()
                ->withHost('laravel-project-starter.test')
                ->withScheme('https')
                ->withPort(null)
                ->value(), 308);
        }

        return $next($request);
    }
}
