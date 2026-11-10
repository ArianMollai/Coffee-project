<?php

namespace App\Services\Role;

use App\Repositories\Role\Contract\RoleRepositoryInterface;
use Illuminate\Support\Collection;
use App\Models\Role;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Services\Role\Contract\RoleServiceInterface;
use App\Services\Users\Contracts\UserServiceInterface;
use Exception;
use Illuminate\Support\Facades\DB;

class RoleService implements RoleServiceInterface
{
    /**
     * Create a new class instance.
     */
    public function __construct(
        private RoleRepositoryInterface $roleRepository,
        private UserServiceInterface $userService
    )
    {}

    public function all(): collection
    {
        return $this->roleRepository->all();
    }


    public function get(int $id): ?Role
    {
        return $this->roleRepository->get($id) ?? throw new Exception("Role not found");
    }


    public function create(array $data): Role
    {
        $permissionIds=$data['permissions'] ?? [];

        return DB::transaction(function() use($data, $permissionIds){
            $role=$this->roleRepository->Create($data) ?? throw new Exception("Couldnt create role");

            if(array_key_exists('permissions', $data)){
                $this->roleRepository->SyncPermisssions($role, $permissionIds);
            }

            return $role->load(['Permissions']);
        });
    }

    public function update(int $id, array $data): Role
    {
        $role = $this->roleRepository->get($id) ?? throw new Exception("Role not found");

        $permissionIds=$data['permissions'] ?? [];

        return DB::transaction(function () use ($role, $data, $permissionIds){
            $updatedRole = $this->roleRepository->update($role, $data);

            if(array_key_exists('permissions', $data)){
                $this->roleRepository->SyncPermisssions($role, $permissionIds);
            }

            return $updatedRole->load('Permissions');
        });
    }


    public function delete(int $id): bool
    {
        $role=$this->roleRepository->get($id) ?? throw new Exception("Role not found");

        $deleted = $this->roleRepository->delete($role) ?? throw new Exception("Couldn't delete role");

        return $deleted;
    }
}
