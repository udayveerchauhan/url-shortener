<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {
        return $user->hasAnyRole(['SuperAdmin', 'Admin']);
    }

    public function invite(User $user, string $role, ?int $companyId = null): bool
    {
        if (! $user->hasAnyRole(['SuperAdmin', 'Admin'])) {
            return false;
        }

        if ($user->hasRole('SuperAdmin')) {
            return in_array($role, ['Admin', 'Mamber'], true);
        }

        if ($user->hasRole('Admin')) {
            return in_array($role, ['Admin', 'Member'], true)
                && intval($companyId) === $user->company_id;
        }

        return false;
    }
}
