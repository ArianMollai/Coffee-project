<?php

namespace App\Services\Authentication\Contracts;

use App\Models\User;

interface AuthenticationServiceInterface
{
    public function AthenticateAccessToken(string $token): ?User;
    public function RefreshAccessToken(string $refreshToken): array;
    public function HasValidTokens(?string $accessToken, ?string $refreshToken): bool;
}
