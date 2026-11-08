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
        $role=$this->roleRepository->Create($data) ?? throw new Exception("Couldnt create role");

        if(isset($data['permissions'])){
            $this->roleRepository->SyncPermisssions($role, $data['permissions']);
        }

        if( isset($data['users'])){
            $this->roleRepository->SyncUsers($role, $data['users']);

            foreach($data['users'] as $userId){
                $this->userService->UpdateUserLevel($userId);
            }
        }

        return $role->load(['Permissions', 'Users']);
    }

    public function update(int $id, array $data): Role
    {
        $role= $this->roleRepository->get($id) ?? throw new Exception("Role not found");

        if(isset($data['users'])){
            $this->roleRepository->SyncUsers($role, $data['users']);

            foreach($data['users'] as $userId){
                $this->userService->UpdateUserLevel($userId);
            }
        }

        $this->roleRepository->SyncPermisssions($role, $data['permissions']);

        $updatedRole = $this->roleRepository->update($role, $data);

        return $updatedRole->load(['Permissions', 'Users']);
    }


    public function delete(int $id): bool
    {
        return DB::transaction(function () use($id){
            $role=$this->roleRepository->get($id) ?? throw new Exception("Role not found");

            $users=$role->Users;

            $deleted = $this->roleRepository->delete($role) ?? throw new Exception("Couldn't delete role");

            foreach($users as $user){
                $this->userService->UpdateUserLevel($user->id);
            }

            return $deleted;
        });
    }
}
