<?php

namespace App\Models\Company;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

/**
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class Company extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $with = ['legalization'];

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
}
