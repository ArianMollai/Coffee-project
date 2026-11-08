<?php

namespace App\Repositories\Role;

use App\Models\Role;
use Illuminate\Support\Collection;
use App\Repositories\Role\Contract\RoleRepositoryInterface;

class RoleRepository implements RoleRepositoryInterface
{

    public function all(): collection
    {
        return Role::with(['Permissions', 'Users'])->latest()->get();
    }

    public function get(int $id): ?Role
    {
        return Role::with(['Permissions', 'Users'])->findOrFail($id);
    }

    public function Create(array $data): Role
    {
        return Role::create($data);
    }

    public function SyncPermisssions(Role $role, array $permissions)
    {
        $role->Permissions()->sync($permissions);
    }

    public function SyncUsers(Role $role, array $users){
        $role->Users()->sync($users);
    }

    public function update(Role $role, array $data): Role
    {
        $role->update($data);

        return $role;
    }

    public function delete(Role $role): bool
    {
        return $role->delete();
    }
}
