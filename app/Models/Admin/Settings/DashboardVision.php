<?php

namespace App\Models\Admin\Settings;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class DashboardVision extends Model
{
    use HasFactory;

    public function dashboard(): BelongsTo
    {
        return $this->belongsTo(Dashboard::class);
    }

    public function scopeActive(Builder $query): void
    {
        $query->where('is_active', 1);
    }
}
