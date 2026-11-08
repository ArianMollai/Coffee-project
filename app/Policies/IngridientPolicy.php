<?php

namespace App\Policies;

use App\Models\Ingridient;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class IngridientPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        if($user->level === 'creator') return true;

        return $user->HasPermission('view-ingridients');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user): bool
    {
        if($user->level==="creator") return true;

        return $user->HasPermission('view-ingridients');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        if($user->level==="creator") return true;

        return $user->HasPermission('create-ingridients');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user): bool
    {
        if($user->level==="creator") return true;

        return $user->HasPermission('update-ingridients');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user): bool
    {
        if($user->level==="creator") return true;

        return $user->HasPermission('delete-ingridients');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user): bool
    {
        return false;
    }
}
