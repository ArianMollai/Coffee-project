<?php

namespace App\Policies;

use App\Models\Role;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class RolePolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewRoles(User $user): bool
    {
        if($user->level==="creator"){
            return true;
        }

        return $user->HasPermission('view-roles');
    }

/*     /**
     * Determine whether the user can view the model.
     */
    public function view(User $user): bool
    {
        if($user->level==="creator"){
            return true;
        }

        return $user->HasPermission('view-roles');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        if($user->level==="creator"){
            return true;
        }

        return $user->HasPermission('create-roles');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user): bool
    {
        if($user->level==="creator"){
            return true;
        }

        return $user->HasPermission("update-roles");
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user): bool
    {
        if($user->level==="creator"){
            return true;
        }

        return $user->HasPermission('delete-roles');
    }

    public function AssignRoles(User $user){
        if($user->level==="creator"){
            return true;
        }

        
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
    public function forceDelete(User $user, Role $role): bool
    {
        return false;
    } 
}
