<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\User;
use App\Notifications\MagicLink;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

final class LoginLinkController
{
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $user = User::query()
            ->where('email', $request->string('email'))
            ->firstOrFail();

        $user->notify(new MagicLink($user));

        return redirect()->back()->with([
            'toast' => 'Magic link sent. Please check your email.',
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user): RedirectResponse
    {
        Auth::login($user);

        return to_route('dashboard');
    }
}
