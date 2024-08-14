<?php

namespace App\Http\Middleware;

use Closure;
use Filament\Facades\Filament;
use Filament\Models\Contracts\FilamentUser;
use Filament\Notifications\Notification;
use Illuminate\Http\Request;

class CanAccessPanel
{
    public function handle(Request $request, Closure $next)
    {
        if (auth()->check() && auth()->user()->is_active) {
            return $next($request);
        }

        $request->session()->put('error', 'Your account is inactive.');
        Notification::make()
            ->title("Akun Belum tervalidasi")
            ->danger()
            ->send();
        Filament::auth()->logout();
        session()->regenerate();
        return redirect()->route('filament.company.auth.login')->with('error', 'Your account is inactive.');
    }
}
