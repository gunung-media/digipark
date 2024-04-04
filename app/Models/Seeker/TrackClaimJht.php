<?php

namespace App\Models\Seeker;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class TrackClaimJht extends Model
{
    use HasFactory;

    public function claimJht(): BelongsTo
    {
        return $this->belongsTo(ClaimJht::class);
    }
}
