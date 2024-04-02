<?php

namespace App\Models\Company;

use App\Models\Job;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

/**
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class Company extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    public function jobs(): HasMany
    {
        return $this->hasMany(Job::class);
    }
}
