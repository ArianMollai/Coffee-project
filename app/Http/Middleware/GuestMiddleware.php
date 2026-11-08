<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Services\Authentication\Contracts\AuthenticationServiceInterface;
use App\Services\Authentication\AuthenticationService;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Auth\AuthenticationException;


class GuestMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */

    public function __construct(private AuthenticationServiceInterface $authentication){}

    public function handle(Request $request, Closure $next): Response
    {
        $accessToken=$request->cookie('access_token');
        $refreshToken=$request->cookie('refresh_token');

        if($this->authentication->HasValidTokens($accessToken, $refreshToken)){
            abort(403, 'You are already logged in.');
        }

        return $next($request);
    }
}
