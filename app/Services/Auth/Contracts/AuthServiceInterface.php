<?php

namespace App\Services\Auth\Contracts;

use App\Models\User;

interface AuthServiceInterface
{
    public function attempt(string $credential, string $password): ?User;
    public function Login(string $credential, string $password, array $allowedLevels): array;
    public function generateTokens(User $user, int $TTL=1000): array;
    public function Register(array $data);
}
