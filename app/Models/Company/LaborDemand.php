<?php

namespace App\Models\Company;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class LaborDemand extends Model
{
    use HasFactory;

    protected $casts = [
        'social_guarantee' => 'array',
    ];

    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }
}
