<?php

namespace App\Repositories\Role\Contract;

use Illuminate\Support\Collection;
use App\Models\Role;


interface RoleRepositoryInterface
{
    public function all(): collection;
    public function get(int $id): ?Role;
    public function Create(array $data): Role;
    public function SyncPermisssions(Role $role, array $permissions);
    public function update(Role $role, array $data): Role;
    public function delete(Role $role): bool;
}
