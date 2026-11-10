<?php

namespace App\Repositories\Users\Contracts;

use App\Models\User;
use Illuminate\Support\Collection;

interface UserReader
{
    public function all(): collection;
    public function find(int $id): ?User;
    public function GetRoles(User $user);
    
}
