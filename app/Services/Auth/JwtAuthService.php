<?php

namespace App\Services\Auth;

use App\Models\User;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Services\Auth\Contracts\AuthServiceInterface;
use App\Repositories\Auth\Contracts\AuthRepository;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Support\Facades\Auth;
use App\Events\UserRegistered;


class JwtAuthService implements AuthServiceInterface
{
    public function __construct(private AuthRepository $auth){}

    public function Register(array $data): User
    {
        $data['password'] = bcrypt($data['password']);

        $user=$this->auth->register($data);

        event(new UserRegistered($user));

        return $user;
    }

    public function Login(string $credential, string $password, array $allowedLevels=[]): array
    {
        $user=$this->attempt($credential, $password);
        if(! $user){
            throw new AuthenticationException('Invalid credentials');
        }

        Auth::setUser($user);

        if( $allowedLevels && ! in_array($user->level, $allowedLevels)){
            throw new AuthorizationException('Not Authorized');
        }

        return $this->generateTokens($user);
    }

    public function attempt(string $credential, string $password): ?User
    {
        $loginField= filter_var($credential, FILTER_VALIDATE_EMAIL) ? 'email' : 'phone_number';

        $credentials=[
            $loginField => $credential,
            'password' => $password
        ];

        if(!JWTAuth::attempt($credentials)){
            return null;
        }

        

        return JWTAuth::user();
    }

    public function generateTokens(User $user, int $refreshTTL=24 * 60 * 7): array
    {
        $accessToken=auth('api')->customClaims(['type' => 'access'])->fromUser($user);

        $refreshToken=auth('api')->claims(['type' => 'refresh'])->setTTL($refreshTTL)->fromUser($user);

        return [
            'access_token' => $accessToken,
            'refresh_token' => $refreshToken
        ];
    }

    public function Logout(string $accessToken, string $refreshToken){
        JWTAuth::setToken($accessToken)->invalidate() ?? throw new Exception("Error happened try again later");

        JWTAuth::setToken($refreshToken)->invalidate() ?? throw new Exception("Error happened try again later");

        return true;
    }
}
