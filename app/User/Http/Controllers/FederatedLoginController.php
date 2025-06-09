<?php

declare(strict_types=1);

namespace App\User\Http\Controllers;

use App\Http\Controllers\Controller;
use App\User\Models\FederatedAccount;
use App\User\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
use Symfony\Component\HttpFoundation\RedirectResponse as SymfonyRedirect;

final class FederatedLoginController extends Controller
{
    public function redirect(string $driver): SymfonyRedirect
    {
        return Socialite::driver($driver)->redirect();
    }

    public function callback(string $driver): RedirectResponse
    {
        $user = Socialite::driver($driver)->user();

        $account = FederatedAccount::query()
            ->where('driver', $driver)
            ->where('external_id', $user->getId())
            ->first();

        if ($account === null) {
            $account = User::query()->firstOrCreate([
                'email' => $user->getEmail(),
            ], [
                'name' => $user->getName(),
            ])->federated_accounts()->create([
                'driver' => $driver,
                'external_id' => $user->getId(),
            ]);
        }

        Auth::login($account->user);

        return to_route('home');
    }
}
