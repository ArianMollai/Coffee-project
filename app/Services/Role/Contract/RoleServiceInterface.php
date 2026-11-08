<?php

namespace App\Services\Role\Contract;

use Illuminate\Support\Collection;
use App\Models\Role;



interface RoleServiceInterface
{
    public function all(): collection;
    public function get(int $id): ?Role;
    public function create(array $data): Role;
    public function update(int $id, array $data): Role;
    public function delete(int $id): bool;
}
