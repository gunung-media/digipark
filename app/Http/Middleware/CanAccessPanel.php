<?php

namespace App\Http\Middleware;

use Closure;
use Filament\Facades\Filament;
use Filament\Models\Contracts\FilamentUser;
use Illuminate\Http\Request;

class CanAccessPanel
{
    public function handle(Request $request, Closure $next)
    {
        if (auth()->check() && auth()->user()->is_active) {
            return $next($request);
        }

        $request->session()->put('error', 'Your account is inactive.');
        return redirect()->route('company.login')->with('error', 'Your account is inactive.');
    }
}
