<?php

namespace App\Models\Seeker;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class ClaimJht extends Model
{
    use HasFactory;

    protected $appends = ['status'];

    public function seeker(): BelongsTo
    {
        return $this->belongsTo(Seeker::class);
    }

    public function tracks(): HasMany
    {
        return $this->hasMany(TrackClaimJht::class);
    }

    public function status(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->tracks->last() ? $this->tracks->last()->status : 'diterima'
        );
    }
}
