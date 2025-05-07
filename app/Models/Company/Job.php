<?php

namespace App\Models\Company;

use App\Models\Seeker\JobApplicant;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class Job extends Model
{
    use HasFactory;

    protected $appends = ['start_date_format', 'deadline_format', 'created_at_format'];

    public function createdAtFormat(): Attribute
    {
        return Attribute::make(
            get: fn() => optional($this->created_at)->format('d-m-Y') ?? null
        );
    }

    public function startDateFormat(): Attribute
    {
        return Attribute::make(
            get: fn() => optional($this->start_date)->format('d-m-Y') ?? null
        );
    }

    public function deadlineFormat(): Attribute
    {
        return Attribute::make(
            get: fn() => optional($this->deadline)->format('d-m-Y') ?? null
        );
    }

    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }

    public function applicants(): HasMany
    {
        return $this->hasMany(JobApplicant::class);
    }

    public function scopeActive(Builder $query): void
    {
        $query->where('is_active', 1);
    }
}
