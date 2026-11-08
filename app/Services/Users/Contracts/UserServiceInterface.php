<?php

namespace App\Services\Users\Contracts;

use Illuminate\Support\Collection;
use App\Models\User;


interface UserServiceInterface
{
    public function list(): Collection;
    public function get(int $id): User;
    public function update(int $id, array $data): User;
    public function delete(int $id): void;
    public function CreateNewUser(array $data): User;
    public function Create(array $data): User;
    public function UpdateUserLevel(int $userId);
}
