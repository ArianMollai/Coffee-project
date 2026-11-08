<?php

namespace App\Repositories\Auth\Contracts;

use App\Models\User;

interface AuthRepository
{
    public function Register(array $data): User;
}
