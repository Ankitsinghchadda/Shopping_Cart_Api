<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Contracts\Auth\Factory as Auth;

class Authenticate
{
    protected $auth;

    public function __construct(Auth $auth)
    {
        $this->auth = $auth;
    }

    // public function handle($request, Closure $next, $guard = null)
    // {
    //     if ($this->auth->guard($guard)->guest()) {
    //         return response('Unauthorized.', 401);
    //     }

    //     return $next($request);
    // }

    // public function handle($request, Closure $next)
    // {
    //     // Perform action
    //     return $next($request);
    // }

    public function handle($request, Closure $next)
    {
        $response = $next($request);
        // Perform action
        return $response;
    }
}
