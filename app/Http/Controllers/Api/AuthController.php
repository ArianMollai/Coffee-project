<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Http\Requests\SignupRequest;
use App\Http\Requests\LoginRequest;
use Illuminate\Http\Request;
use App\Services\Auth\Contracts\AuthServiceInterface;
use Tymon\JWTAuth\Facades\JWTAuth;
use Exception;
use Throwable;

class AuthController extends Controller
{
    public function __construct(
        protected AuthServiceInterface $authService
    ){}

    public function Register(SignupRequest $request)
    {
        $user=$this->authService->Register($request->validated());
        if(! $user){ throw new Exception('Couldnt create user');}

        return response()->json([
            'message' => 'user created successfully'
        ],201);
    }


    public function Login(LoginRequest $request){
       $validated=$request->validated();

       $tokens=$this->authService->Login($validated['credential'], $validated['password'], ['user']);

       return response()->json(['message' => 'wellcome in'])->cookie('access_token', $tokens['access_token'], 15, '/', null, false, true, false, 'Lax')->cookie('refresh_token', $tokens['refresh_token'],  60 * 24 * 7, '/', null, false, true, false, 'Lax');

    }

    
    public function adminLogin(LoginRequest $request){
       $validated=$request->validated();

        $tokens=$this->authService->login($validated['credential'], $validated['password'], ['admin', 'creator']);

        return response()->json(['message' => 'wellcome in'])->cookie('access_token', $tokens['access_token'], 15, '/', null, false, true, false, 'Lax')->cookie('refresh_token', $tokens['refresh_token'],  60 * 24 * 7, '/', null, false, true, false, 'Lax');
    }

    public function Logout(Request $request){
        $accessToken=$request->cookie('access_token');
        $refreshToken=$request->cookie('refresh_token');

        if(!$accessToken && !$refreshToken){
            throw new Exception("Ypu arent logged in");
        }

        if($this->authService->Logout($accessToken, $refreshToken));

        return response()->json([
            'message' => 'logged out successfully'
        ])->withCookie(cookie()->forget('access_token'))->withCookie(cookie()->forget('refresh_token'));
    }
}
