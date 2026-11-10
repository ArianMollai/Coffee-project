<?php

namespace App\Services\Authentication;

use App\Services\Authentication\Contracts\AuthenticationServiceInterface;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Illuminate\Auth\AuthenticationException;
use App\Models\User;

class AuthenticationService implements AuthenticationServiceInterface
{
    public function AthenticateAccessToken(string $token): ?User
    {
        return $this->AuthenticateTokes($token, 'access');
    }

    public function RefreshAccessToken(string $refreshToken): array
    {
        $user=$this->AuthenticateTokes($refreshToken, 'refresh');
        if(! $user){
            throw new AuthenticationException('Invalid or expired token 1.');
        }

        $newAccessToken=auth('api')->customClaims(['type' => 'access'])->fromUser($user);

        return ['user' => $user, 'access_token' => $newAccessToken];
    }

    private function AuthenticateTokes(string $token, string $expectedType): ?User
    {
        try{
            $jwt=JWTAuth::setToken($token);
            $payload=$jwt->getPayload();
            $user=$jwt->authenticate();
        }catch(JWTException $e){
            throw new AuthenticationException('Invalid or expired token 2.');
        }

        if(! $user || $payload->get('type') !== $expectedType){
            throw new AuthenticationException('Invalid or expired token 3.');
        }

        return $user;
    }

    public function HasValidTokens(?string $accessToken, ?string $refreshToken): bool
    {
        if( $accessToken && $this->AthenticateAccessToken($accessToken)){
            return true;
        }

        if( $refreshToken && $this->RefreshAccessToken($refreshToken)){
            return true;
        }

        return false;
    }
}
