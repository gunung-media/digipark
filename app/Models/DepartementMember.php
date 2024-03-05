<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class DepartementMember extends Model
{
    use HasFactory;

    public function scopeActive(Builder $query): void
    {
        $query->where('is_active', 1);
    }
}
