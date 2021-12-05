<?php

namespace App\Policies;

use App\Models\Tag;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class TagPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(?User $user)
    {
        return config('auth.allow_guests') || $user !== null;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(?User $user, Tag $tag)
    {
        return config('auth.allow_guests') || $user !== null;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user)
    {
        return true;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Tag $tag)
    {
        return $user->role == User::ROLE_MOD
            || $user->role == User::ROLE_ADMIN;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Tag $tag)
    {
        return $user->role == User::ROLE_MOD
            || $user->role == User::ROLE_ADMIN;
    }
}
