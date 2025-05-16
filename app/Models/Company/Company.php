<?php

namespace App\Models\Company;

use App\Models\Seeker\Seeker;
use Filament\Models\Contracts\FilamentUser;
use Filament\Panel;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

/**
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class Company extends Authenticatable implements FilamentUser
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $casts = [
        'is_active' => 'boolean',
    ];

    protected $with = ['laidOffs', 'jobs', 'placements', 'legalization', 'laborDemands'];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($user) {
            if (isset($user->password)) {
                $user->password_raw = $user->password;
                $user->password = bcrypt($user->password);
            }
        });
    }

    public function laidOffs(): HasMany
    {
        return $this->hasMany(CompanyLaidOff::class);
    }

    public function jobs(): HasMany
    {
        return $this->hasMany(Job::class);
    }

    public function placements(): HasMany
    {
        return $this->hasMany(Placement::class);
    }

    public function legalization(): HasOne
    {
        return $this->hasOne(CompanyLegalization::class);
    }

    public function laborDemands(): HasMany
    {
        return $this->hasMany(LaborDemand::class);
    }

    public function canAccessPanel(Panel $panel): bool
    {
        return true;
        // return $thik->is_active;
    }

    public function scopeActive(Builder $query): void
    {
        $query->where('is_active', 1);
    }

    public function seekers(): HasMany
    {
        return $this->hasMany(Seeker::class);
    }
}
