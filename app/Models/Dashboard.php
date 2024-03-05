<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class Dashboard extends Model
{
    use HasFactory;

    public function images(): HasMany
    {
        return $this->hasMany(DashboardImage::class);
    }

    public function visions(): HasMany
    {
        return $this->hasMany(DashboardVision::class);
    }

    public function testimonials(): HasMany
    {
        return $this->hasMany(DashboardTestimonial::class);
    }
}
