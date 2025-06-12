<?php

declare(strict_types=1);

namespace App\User\Http\Controllers\Identity;

use Laravel\Socialite\Facades\Socialite;
use Symfony\Component\HttpFoundation\RedirectResponse as SymfonyRedirect;

final class RedirectController
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(string $driver): SymfonyRedirect
    {
        return Socialite::driver($driver)->redirect();
    }
}
