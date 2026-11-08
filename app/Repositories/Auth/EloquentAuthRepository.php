<?php

namespace App\Repositories\Auth;

use App\Repositories\Auth\Contracts\AuthRepository;
use App\Models\User;

class EloquentAuthRepository implements AuthRepository
{
    public function Register(array $data): User
    {
        $user=User::create($data);

        return $user;
    } 
}
