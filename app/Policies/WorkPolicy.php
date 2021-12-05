<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Work;
use Illuminate\Auth\Access\HandlesAuthorization;

class WorkPolicy
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
    public function view(?User $user, Work $work)
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
    public function update(User $user, Work $work)
    {
        return $user->id === $work->user_id
            || $user->role == User::ROLE_MOD
            || $user->role == User::ROLE_ADMIN;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Work $work)
    {
        return $user->id === $work->user_id
            || $user->role == User::ROLE_MOD
            || $user->role == User::ROLE_ADMIN;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Work $work)
    {
        return $user->role == User::ROLE_MOD
            || $user->role == User::ROLE_ADMIN;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Work $work)
    {
        return $user->role == User::ROLE_MOD
            || $user->role == User::ROLE_ADMIN;
    }
}
