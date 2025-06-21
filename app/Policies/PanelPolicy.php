<?php

declare(strict_types=1);

namespace App\Policies;

use App\Models\User;
use Filament\Panel;

final class PanelPolicy
{
    /**
     * Determine whether the user can access the panel.
     */
    public function access(User $user): bool
    {
        return $user->email === 'eszter.czotter@gmail.com';
    }
}
