<?php

namespace App\Repositories\Users;

use App\Repositories\Users\Contracts\UserRepository;
use App\Models\User;
use Illuminate\Support\Collection;


class EloquentUserRepository implements UserRepository
{
    public function all(): Collection
    {
        return User::latest()->get();
    }

    public function find(int $id): ?User
    {
        return User::find($id);
    }

    public function Create(array $data): User
    {
        return User::create($data);
    }

    public function update(User $user, array $data): ?User
    {
        $user->update($data);
        return $user;
    }

    public function delete(User $user): void
    {
        $user->delete();
    }

    public function SyncRoles(User $user, array $roleIds){
        return $user->Roles()->sync($roleIds);
    }
}   
