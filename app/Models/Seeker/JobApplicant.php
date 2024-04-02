<?php

namespace App\Models\Seeker;

use App\Models\Company\Job;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class JobApplicant extends Model
{
    use HasFactory;

    public function updatedAt(): Attribute
    {
        return Attribute::make(
            get: fn ($val) => $this->is_accepted ? Carbon::parse($val)->format('d M, Y')  :  '-',
        );
    }

    public function job(): BelongsTo
    {
        return $this->belongsTo(Job::class);
    }

    public function seeker(): BelongsTo
    {
        return $this->belongsTo(Seeker::class);
    }
}
