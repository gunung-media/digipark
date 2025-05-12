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

            $request->attributes->set('auth_guard', $guard);
        }

        return redirect()->route($this->determineRedirectRoute($request));
    }

    protected function redirectTo($request): ?string
    {
        return $this->determineRedirectRoute($request);
    }

    protected function determineRedirectRoute(Request $request): string
    {
        if ($request->expectsJson()) {
            return '';
        }

        if ($request->is('mobile') || $request->is('mobile/*')) {
            return 'mobile.login';
        }

        $guard = $request->attributes->get('auth_guard');

        return match ($guard) {
            'company' => 'portal.login',
            default => 'admin.login',
        };
    }
}
