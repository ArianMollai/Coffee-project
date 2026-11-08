<?php

namespace App\Repositories\Users\Contracts;

use App\Models\User;


interface UserWritter
{
    public function Create(array $data): User;
    public function update(User $user, array $data);
    public function delete(User $user);
    public function SyncRoles(User $user, array $roleIds);
}