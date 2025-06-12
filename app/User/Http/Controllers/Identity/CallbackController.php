<?php

declare(strict_types=1);

namespace App\User\Http\Controllers\Identity;

use App\User\Models\Identity;
use App\User\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

final class CallbackController
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(string $driver): RedirectResponse
    {
        $user = Socialite::driver($driver)->user();

        $account = Identity::query()
            ->where('driver', $driver)
            ->where('external_id', $user->getId())
            ->first();

        if ($account === null) {
            $account = User::query()->firstOrCreate([
                'email' => $user->getEmail(),
            ], [
                'name' => $user->getName(),
            ])->identities()->create([
                'driver' => $driver,
                'external_id' => $user->getId(),
            ]);
        }

        Auth::login($account->user);

        return to_route('dashboard');
    }
}
