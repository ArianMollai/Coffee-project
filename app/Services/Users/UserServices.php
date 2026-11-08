<?php

namespace App\Services\Users;

use App\Repositories\Users\Contracts\UserRepository;
use App\Services\Users\Contracts\UserServiceInterface;
use App\Models\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Collection;
use Tymon\JWTAuth\Facades\JWTAuth; 

class UserServices implements UserServiceInterface
{
    /**
     * Create a new class instance.
     */
    public function __construct(private UserRepository $user)
    {}

    public function list(): Collection
    {
        return $this->user->all();
    }

    public function get(int $id): User
    {
        return $this->user->find($id) ?? throw new ModelNotFoundException("User not found");
    }

    public function Create(array $data): User
    {
        return $this->user->Create($data);
    }

    public function update(int $id, array $data): User
    {
        $user=$this->get($id) ?? throw new ModelNotFoundException('User not found');

        $roleIds=$data['role_ids'] ?? [];

        $data['level'] = !empty($roleIds) ? 'admin' : 'user';

        return $this->user->update($user, $data);
    }

    public function delete(int $id): void
    {
        $this->user->delete($this->get($id));
    }

    public function CreateNewUser(array $data): User
    {
        $data['password'] = bcrypt($data['password']);

        $roleIds= $data['role_ids'] ?? [];

        $data['level'] = !empty($roleIds) ? 'admin' : 'user';

        $user=$this->Create($data);

        $this->user->SyncRoles($user, $data['role_ids']);

        return $user->load('Roles');
    }

    public function UpdateUserLevel(int $userId){
        $user=$this->user->find($userId) ?? throw new ModelNotFoundException('User not found');

        $level=$user->Roles()->exists() ? 'admin' : 'user';

        return $this->user->update($user, ['level' => $level]);

    }

}

