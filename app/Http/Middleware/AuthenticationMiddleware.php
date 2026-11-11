<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Support\Facades\Auth;
use App\Services\Authentication\Contracts\AuthenticationServiceInterface;

class AuthenticationMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function __construct(private AuthenticationServiceInterface $authentication){}

    public function handle(Request $request, Closure $next): Response
    {
        if($accessToken=$request->cookie('access_token')){
            try{
                Auth::setUser($this->authentication->AthenticateAccessToken($accessToken));

                return $next($request);

            }catch(AuthenticationException){
                //
            }
        }

        $refreshToken=$request->cookie('refresh_token');
        if(! $refreshToken){
            throw new AuthenticationException('Please login again');
        }

        $result=$this->authentication->RefreshAccessToken($refreshToken);
        Auth::setUser($result['user']);

        $response=$next($request);

        $response->headers->setCookie(cookie('access_token', $result['access_token'],  15, '/', null, true, true, false, 'Lax'));

        return $response;
    }
}
