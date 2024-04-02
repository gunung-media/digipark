<?php

namespace App\Models\Seeker;

use App\Models\Company\Job;
use Filament\Panel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Filament\Models\Contracts\FilamentUser;
use Filament\Models\Contracts\HasName;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class Seeker extends Authenticatable implements FilamentUser, HasName
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $with = ['additional'];

    public function getFilamentName(): string
    {
        return "{$this->full_name}";
    }

    public function canAccessPanel(Panel $panel): bool
    {
        return true;
    }

    public function jobs(): HasMany
    {
        return $this->hasMany(Job::class);
    }

    public function additional(): HasOne
    {
        return $this->hasOne(SeekerAdditional::class);
    }

    public function claimJhts(): HasMany
    {
        return $this->hasMany(ClaimJht::class);
    }
}
