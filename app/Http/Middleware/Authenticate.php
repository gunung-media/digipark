<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\Request;

class Authenticate extends Middleware
{

    public function handle($request, Closure $next, ...$guards): mixed
    {
        foreach ($guards as $guard) {
            if ($this->auth->guard($guard)->check()) {
                return $next($request);
            }
            return redirect()->route($this->redirectTo($guard));
        }
    }

    protected function redirectTo($guard): String
    {
        switch ($guard) {
            case 'company':
                return 'portal.login';
            default:
                return 'admin.login';
        }
    }
}
