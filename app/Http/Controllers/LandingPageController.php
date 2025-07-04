<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Container\Attributes\CurrentUser;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;
use Inertia\Response;

final class LandingPageController
{
    public function __invoke(#[CurrentUser] ?User $user): Response|RedirectResponse
    {
        if (! $user instanceof User) {
            return Inertia::render('Landing');
        }

        return Redirect::route('home');
    }
}
