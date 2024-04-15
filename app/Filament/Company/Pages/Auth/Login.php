<?php

namespace App\Filament\Company\Pages\Auth;

use Filament\Pages\Auth\Login as AuthLogin;
use Illuminate\Contracts\Support\Htmlable;

class Login extends AuthLogin
{
    public function getHeading(): string|Htmlable
    {
        return __("Masuk ke akun Perusahaan Anda");
    }
}
