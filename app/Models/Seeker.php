<?php

namespace App\Models;

use Filament\Panel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Filament\Models\Contracts\FilamentUser;
use Filament\Models\Contracts\HasName;

/**
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class Seeker extends Authenticatable implements FilamentUser, HasName
{
    use HasApiTokens, HasFactory, Notifiable;

    public function getFilamentName(): string
    {
        return "{$this->full_name}";
    }

    public function canAccessPanel(Panel $panel): bool
    {
        return true;
    }
}
