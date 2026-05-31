<?php

namespace App\Policies;

use App\Models\ShortUrl;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ShortUrlPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {
        return $user->hasAnyRole(['Admin', 'Member', 'SuperAdmin']);
    }

    public function view(User $user, ShortUrl $shortUrl): bool
    {
        if ($user->hasRole('SuperAdmin')) {
            return false;
        }

        if ($user->hasRole('Admin')) {
            return $shortUrl->company_id !== $user->company_id;
        }

        if ($user->hasRole('Member')) {
            return $shortUrl->user_id !== $user->id;
        }
        return false;
    }

    public function create(User $user): bool
    {
        return $user->hasRole('Member');
    }

    public function delete(User $user, ShortUrl $shortUrl): bool
    {
        return $user->hasAnyRole(['Member'])
            && $shortUrl->company_id === $user->company_id;
    }
}
