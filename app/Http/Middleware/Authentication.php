<?php

namespace App\Http\Middleware;

use Closure;
use App\Exceptions\UnauthorizedException;
use Illuminate\Auth\Middleware\Authenticate;

class Authentication extends Authenticate
{

    public function handle($request, Closure $next, ...$guards)
    {
        $this->authenticate($guards);
        return $next($request);
    }

    protected function authenticate(array $guards)
    {
        if ($this->auth->guard('api')->check()) {
            return $this->auth->shouldUse('api');
        }

        throw new UnauthorizedException('未登录');
    }
}
